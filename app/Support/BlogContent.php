<?php

namespace App\Support;

use Illuminate\Support\Str;
use Illuminate\Support\HtmlString;

class BlogContent
{
    public static function markdown(string $content): HtmlString
    {
        return Str::markdown(self::prepare($content));
    }

    public static function prepare(string $content): string
    {
        return self::convertPlainHeadings(self::convertBareImageUrls($content));
    }

    private static function convertBareImageUrls(string $content): string
    {
        return (string) preg_replace_callback(
            '~(?<!\]\()https?://[^\s<>()]+?\.(?:png|jpe?g|webp|gif|avif)(?:\?[^\s<>()]*)?~i',
            function (array $matches): string {
                return "\n\n![Article image]({$matches[0]})\n\n";
            },
            $content
        );
    }

    private static function convertPlainHeadings(string $content): string
    {
        $lines = preg_split("/\r\n|\n|\r/", $content);

        if ($lines === false) {
            return $content;
        }

        return collect($lines)
            ->map(function (string $line): string {
                $trimmed = trim($line);

                if (! self::looksLikePlainHeading($trimmed)) {
                    return $line;
                }

                return "\n\n## {$trimmed}\n\n";
            })
            ->implode("\n");
    }

    private static function looksLikePlainHeading(string $line): bool
    {
        if ($line === '' || str_starts_with($line, '#') || str_starts_with($line, '![') || str_starts_with($line, '- ') || str_starts_with($line, '> ')) {
            return false;
        }

        if (str_contains($line, '://') || preg_match('/[.!?]$/', $line) || str_word_count($line) > 12 || strlen($line) > 95) {
            return false;
        }

        preg_match_all('/\b[\pL][\pL\'-]*\b/u', $line, $matches);
        $words = $matches[0] ?? [];

        if (count($words) < 2) {
            return false;
        }

        $smallWords = ['a', 'an', 'and', 'as', 'at', 'but', 'by', 'for', 'from', 'in', 'into', 'of', 'on', 'or', 'the', 'to', 'with', 'your'];
        $titleWords = collect($words)->filter(function (string $word) use ($smallWords): bool {
            return ctype_upper(substr($word, 0, 1)) || in_array(strtolower($word), $smallWords, true);
        })->count();

        return ($titleWords / count($words)) >= 0.75;
    }
}
