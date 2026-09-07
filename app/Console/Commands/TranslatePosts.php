<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class TranslatePosts extends Command
{
    protected $signature = 'posts:translate
        {target : Target language: en or ru}
        {--force : Translate posts that already have a target version again}
        {--limit= : Limit the number of source posts for testing}';

    protected $description = 'Translate Vietnamese posts with the configured AI model while preserving HTML';

    private string $target;

    public function handle(): int
    {
        $this->target = strtolower((string) $this->argument('target'));
        if (!in_array($this->target, ['en', 'ru'], true)) {
            $this->error('Target language must be en or ru.');

            return self::INVALID;
        }
        if (!filled(config('services.translation_ai.api_key'))) {
            $this->error('TRANSLATION_AI_API_KEY is not configured.');

            return self::FAILURE;
        }

        $query = Post::where('locale', 'vi')->orderBy('id');
        if ($limit = (int) $this->option('limit')) {
            $query->limit(max(1, $limit));
        }
        $posts = $query->get();
        $progress = $this->output->createProgressBar($posts->count());
        $progress->start();
        $translated = 0;
        $skipped = 0;
        $failed = [];

        foreach ($posts as $source) {
            $slug = $this->translatedSlug($source->slug);
            if (!$this->option('force') && Post::where('slug', $slug)->where('locale', $this->target)->exists()) {
                $skipped++;
                $progress->advance();
                continue;
            }

            try {
                $translation = $this->translate($source->title, $source->summary, $source->content);
                Post::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'post_category_id' => $source->post_category_id,
                        'locale' => $this->target,
                        'title' => Str::limit($translation['title'], 255, ''),
                        'thumbnail' => $source->thumbnail,
                        'summary' => filled($translation['summary']) ? Str::limit($translation['summary'], 500, '') : null,
                        'content' => $translation['content'],
                        'meta_title' => Str::limit($translation['title'], 255, ''),
                        'meta_description' => filled($translation['summary']) ? Str::limit($translation['summary'], 500, '') : null,
                        'status' => $source->status,
                        'published_at' => $source->published_at,
                    ],
                );
                $translated++;
            } catch (\Throwable $exception) {
                $failed[] = $source->slug.': '.$exception->getMessage();
            }
            $progress->advance();
        }

        $progress->finish();
        $this->newLine(2);
        $this->info("Translated {$translated}, skipped {$skipped}, failed ".count($failed).'.');
        foreach ($failed as $failure) {
            $this->warn($failure);
        }

        return $failed ? self::FAILURE : self::SUCCESS;
    }

    private function translate(string $title, ?string $summary, ?string $content): array
    {
        $language = $this->target === 'en' ? 'English' : 'Russian';
        $response = Http::acceptJson()
            ->withToken(config('services.translation_ai.api_key'))
            ->timeout(180)
            ->retry(4, 2000)
            ->post(rtrim(config('services.translation_ai.base_url'), '/').'/chat/completions', [
                'model' => config('services.translation_ai.model'),
                'temperature' => 0.1,
                'max_tokens' => 16000,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "You are a professional Vietnamese to {$language} translator for Nhat Duong, a passenger bus company. Translate accurately and naturally for travellers. Preserve every HTML tag, attribute, URL, image path, phone number, price, date, and paragraph structure in content. Keep the brand names Nhat Duong and Binh Minh Bus unchanged in Latin characters. Return only a valid JSON object with exactly the string keys title, summary, and content. Do not use Markdown fences or add commentary.",
                    ],
                    [
                        'role' => 'user',
                        'content' => json_encode([
                            'title' => $title,
                            'summary' => $summary ?? '',
                            'content' => $content ?? '',
                        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                    ],
                ],
            ]);

        if (!$response->successful()) {
            throw new RuntimeException('AI API returned HTTP '.$response->status().'.');
        }

        $answer = trim((string) $response->json('choices.0.message.content'));
        $start = strpos($answer, '{');
        $end = strrpos($answer, '}');
        if ($start === false || $end === false || $end <= $start) {
            throw new RuntimeException('AI API did not return a JSON object.');
        }

        try {
            $translated = json_decode(substr($answer, $start, $end - $start + 1), true, flags: JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            throw new RuntimeException('AI API returned invalid JSON: '.$exception->getMessage());
        }

        foreach (['title', 'summary', 'content'] as $field) {
            if (!array_key_exists($field, $translated) || !is_string($translated[$field])) {
                throw new RuntimeException("AI response is missing {$field}.");
            }
        }

        return $translated;
    }

    private function translatedSlug(string $sourceSlug): string
    {
        return Str::limit($sourceSlug, 252, '').'-'.$this->target;
    }
}
