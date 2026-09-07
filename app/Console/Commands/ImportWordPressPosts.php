<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\PostCategory;
use DOMDocument;
use DOMElement;
use Illuminate\Console\Command;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class ImportWordPressPosts extends Command
{
    protected $signature = 'posts:import-wordpress
        {--source=https://nhaxenhatduong.com : WordPress website URL}
        {--without-images : Keep remote image URLs instead of downloading images}';

    protected $description = 'Import all published posts and categories from a WordPress REST API';

    private string $source;

    private bool $downloadImages;

    public function handle(): int
    {
        $this->source = rtrim((string) $this->option('source'), '/');
        $this->downloadImages = !$this->option('without-images');

        try {
            $categories = $this->importCategories();
            $firstPage = $this->get('/wp-json/wp/v2/posts', $this->postParameters(1));
            $pages = max(1, (int) $firstPage->header('X-WP-TotalPages'));
            $expected = (int) $firstPage->header('X-WP-Total');
        } catch (\Throwable $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }

        $this->info("Importing {$expected} posts from {$this->source}...");
        $progress = $this->output->createProgressBar($expected);
        $progress->start();
        $imported = 0;
        $failed = [];

        for ($page = 1; $page <= $pages; $page++) {
            try {
                $posts = $page === 1 ? $firstPage->json() : $this->get('/wp-json/wp/v2/posts', $this->postParameters($page))->json();
            } catch (\Throwable $exception) {
                $failed[] = "Page {$page}: {$exception->getMessage()}";
                continue;
            }

            foreach ($posts as $wordpressPost) {
                try {
                    $this->importPost($wordpressPost, $categories);
                    $imported++;
                } catch (\Throwable $exception) {
                    $failed[] = ($wordpressPost['slug'] ?? 'unknown').': '.$exception->getMessage();
                }
                $progress->advance();
            }
        }

        $progress->finish();
        $this->newLine(2);
        $this->info("Imported or updated {$imported} posts.");

        foreach ($failed as $failure) {
            $this->warn($failure);
        }

        return $failed ? self::FAILURE : self::SUCCESS;
    }

    private function importCategories(): array
    {
        $response = $this->get('/wp-json/wp/v2/categories', [
            'per_page' => 100,
            'hide_empty' => false,
        ]);
        $categories = [];

        foreach ($response->json() as $wordpressCategory) {
            if ((int) ($wordpressCategory['count'] ?? 0) === 0) {
                continue;
            }

            $category = PostCategory::updateOrCreate(
                ['slug' => $wordpressCategory['slug']],
                [
                    'name' => $this->plainText($wordpressCategory['name']),
                    'description' => $this->plainText($wordpressCategory['description'] ?? ''),
                    'status' => true,
                ],
            );
            $categories[(int) $wordpressCategory['id']] = $category;
        }

        return $categories;
    }

    private function importPost(array $wordpressPost, array $categories): void
    {
        $title = $this->plainText(data_get($wordpressPost, 'title.rendered', ''));
        $summary = Str::of($this->plainText(data_get($wordpressPost, 'excerpt.rendered', '')))
            ->replace(['[...]', '[…]'], '')
            ->squish()
            ->limit(500, '')
            ->value();
        $content = data_get($wordpressPost, 'content.rendered', '');
        $content = $this->prepareContent($content);
        $category = collect($wordpressPost['categories'] ?? [])
            ->map(fn ($id) => $categories[(int) $id] ?? null)
            ->filter()
            ->sortByDesc(fn (PostCategory $item) => $item->slug === 'tin-tuc')
            ->first();
        $thumbnail = $this->featuredImage($wordpressPost);

        Post::updateOrCreate(
            ['slug' => $wordpressPost['slug']],
            [
                'post_category_id' => $category?->id,
                'locale' => 'vi',
                'title' => $title,
                'thumbnail' => $thumbnail,
                'summary' => $summary ?: null,
                'content' => $content,
                'meta_title' => Str::limit($title, 255, ''),
                'meta_description' => $summary ?: null,
                'status' => true,
                'published_at' => $wordpressPost['date'] ?? now(),
            ],
        );
    }

    private function prepareContent(string $html): string
    {
        if (blank($html)) {
            return '';
        }

        $document = new DOMDocument('1.0', 'UTF-8');
        $previousErrors = libxml_use_internal_errors(true);
        $document->loadHTML('<?xml encoding="UTF-8"><div id="wordpress-content">'.$html.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($previousErrors);
        $container = $document->getElementById('wordpress-content');

        if (!$container) {
            return strip_tags($html, '<p><br><h2><h3><h4><ul><ol><li><blockquote><strong><b><em><i><u><a><img><figure><figcaption>');
        }

        foreach (['script', 'style', 'iframe', 'form', 'input', 'button'] as $tag) {
            foreach (iterator_to_array($container->getElementsByTagName($tag)) as $node) {
                $node->parentNode?->removeChild($node);
            }
        }

        foreach (iterator_to_array($container->getElementsByTagName('*')) as $element) {
            foreach (iterator_to_array($element->attributes ?? []) as $attribute) {
                if (str_starts_with(strtolower($attribute->name), 'on')) {
                    $element->removeAttribute($attribute->name);
                }
            }
        }

        foreach (iterator_to_array($container->getElementsByTagName('img')) as $image) {
            $source = $image->getAttribute('src');
            if ($this->downloadImages && $this->isSourceImage($source)) {
                $stored = $this->downloadImage($source);
                if ($stored) {
                    $image->setAttribute('src', Storage::url($stored));
                }
            }
            $image->removeAttribute('srcset');
            $image->removeAttribute('sizes');
            $image->setAttribute('loading', 'lazy');
        }

        $result = '';
        foreach ($container->childNodes as $node) {
            $result .= $document->saveHTML($node);
        }

        return trim($result);
    }

    private function featuredImage(array $wordpressPost): ?string
    {
        $url = data_get($wordpressPost, '_embedded.wp:featuredmedia.0.source_url');

        return $this->downloadImages && $url ? $this->downloadImage($url) : null;
    }

    private function downloadImage(string $url): ?string
    {
        $path = parse_url(html_entity_decode($url), PHP_URL_PATH);
        $extension = strtolower(pathinfo((string) $path, PATHINFO_EXTENSION));
        $extension = in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true) ? $extension : 'jpg';
        $storagePath = 'posts/imported/'.sha1($url).'.'.$extension;

        if (Storage::disk('public')->exists($storagePath)) {
            return $storagePath;
        }

        try {
            $response = Http::timeout(30)->retry(2, 500)->get($url);
            if (!$response->successful() || !str_starts_with(strtolower($response->header('Content-Type')), 'image/')) {
                return null;
            }
            Storage::disk('public')->put($storagePath, $response->body());

            return $storagePath;
        } catch (\Throwable) {
            return null;
        }
    }

    private function isSourceImage(string $url): bool
    {
        $host = parse_url(html_entity_decode($url), PHP_URL_HOST);

        return $host && in_array(strtolower($host), ['nhaxenhatduong.com', 'www.nhaxenhatduong.com'], true);
    }

    private function plainText(string $value): string
    {
        return trim(html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }

    private function postParameters(int $page): array
    {
        return [
            'per_page' => 20,
            'page' => $page,
            'status' => 'publish',
            '_embed' => 'wp:featuredmedia',
            'orderby' => 'date',
            'order' => 'asc',
        ];
    }

    private function get(string $path, array $parameters): Response
    {
        $response = Http::acceptJson()
            ->withUserAgent('NhatDuong Website Content Migration')
            ->timeout(60)
            ->retry(3, 700)
            ->get($this->source.$path, $parameters);

        if (!$response->successful()) {
            throw new RuntimeException("WordPress returned HTTP {$response->status()} for {$path}.");
        }

        return $response;
    }
}
