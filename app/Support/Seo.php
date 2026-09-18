<?php

namespace App\Support;

use Artesaos\SEOTools\Facades\JsonLdMulti;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;

final class Seo
{
    public static function configure(
        string $title,
        string $description,
        string $canonical,
        string $locale = 'vi',
        string $openGraphType = 'website',
        string $schemaType = 'WebPage',
        ?string $image = null,
        array $schema = [],
    ): void {
        $canonical = self::url($canonical);
        $image = self::assetUrl($image ?: '/Nhat-Duong-Logo-1-768x543.png');
        $description = trim(strip_tags($description));

        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical($canonical);

        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        OpenGraph::setUrl($canonical);
        OpenGraph::setType($openGraphType);
        OpenGraph::setSiteName('Nhà Xe Nhật Dương');
        OpenGraph::addProperty('locale', self::openGraphLocale($locale));
        OpenGraph::addImage($image, ['alt' => $title]);

        TwitterCard::setType('summary_large_image');
        TwitterCard::setTitle($title);
        TwitterCard::setDescription($description);
        TwitterCard::setUrl($canonical);
        TwitterCard::setImage($image);

        JsonLdMulti::setType($schemaType);
        JsonLdMulti::setTitle($title);
        JsonLdMulti::setDescription($description);
        JsonLdMulti::setUrl($canonical);
        JsonLdMulti::setImage($image);
        JsonLdMulti::addValue('inLanguage', $locale);
        if ($schema !== []) {
            JsonLdMulti::addValues($schema);
        }
    }

    public static function route(string $name, array $parameters = []): string
    {
        return self::url(route($name, $parameters, false));
    }

    public static function alternates(string $name, array $parameters = []): array
    {
        return collect(['vi', 'en', 'ru'])->mapWithKeys(fn (string $locale) => [
            $locale => self::route($name, [...$parameters, 'lang' => $locale]),
        ])->all();
    }

    public static function url(string $path): string
    {
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            $parts = parse_url($path);
            $path = ($parts['path'] ?? '/').(isset($parts['query']) ? '?'.$parts['query'] : '');
        }

        return rtrim((string) config('app.url'), '/').'/'.ltrim($path, '/');
    }

    public static function assetUrl(string $path): string
    {
        return filter_var($path, FILTER_VALIDATE_URL) ? $path : self::url($path);
    }

    private static function openGraphLocale(string $locale): string
    {
        return match ($locale) {
            'en' => 'en_US',
            'ru' => 'ru_RU',
            default => 'vi_VN',
        };
    }
}
