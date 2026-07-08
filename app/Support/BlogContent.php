<?php

namespace App\Support;

use Illuminate\Support\HtmlString;

class BlogContent
{
    private const LINK_TARGET_PATTERN = '(?:https?:\/\/|\/|mailto:|tel:)[^)]+|(?:www\.)?[a-z0-9.-]+\.[a-z]{2,}[^\s)]*';

    public static function markdown(string $content): HtmlString
    {
        return new HtmlString(self::render(self::prepare($content)));
    }

    public static function prepare(string $content): string
    {
        return self::convertPlainHeadings($content);
    }

    private static function render(string $content): string
    {
        $lines = preg_split("/\r\n|\n|\r/", $content);

        if ($lines === false) {
            return '';
        }

        $html = [];
        $paragraph = [];

        $flushParagraph = function () use (&$html, &$paragraph): void {
            if ($paragraph === []) {
                return;
            }

            $html[] = '<p>'.self::renderInline(implode(' ', $paragraph)).'</p>';
            $paragraph = [];
        };

        foreach ($lines as $rawLine) {
            $line = trim($rawLine);

            if ($line === '') {
                $flushParagraph();
                continue;
            }

            if (preg_match('/^(#{1,6})\s+(.+)$/', $line, $matches)) {
                $flushParagraph();
                $level = min(6, strlen($matches[1]));
                $html[] = "<h{$level}>".e($matches[2])."</h{$level}>";
                continue;
            }

            if (preg_match('~^(https?://[^\s<>()]+?\.(?:png|jpe?g|webp|gif|avif)(?:\?[^\s<>()]*)?)(.*)$~i', $line, $matches)) {
                $flushParagraph();
                $html[] = '<img src="'.e($matches[1]).'" alt="Article image">';

                if (trim($matches[2]) !== '') {
                    $html[] = '<p>'.e(trim($matches[2])).'</p>';
                }

                continue;
            }

            $paragraph[] = $line;
        }

        $flushParagraph();

        return implode("\n", $html);
    }

    private static function renderInline(string $text): string
    {
        $html = e($text);

        $html = (string) preg_replace(
            '/!\[([^\]]*)\]\((https?:\/\/[^)]+)\)/',
            '<img src="$2" alt="$1">',
            $html
        );

        $html = (string) preg_replace_callback(
            '/\[([^\]]+)\]\(('.self::LINK_TARGET_PATTERN.')\)(\{([^}]*)\})?/i',
            function (array $matches): string {
                $href = html_entity_decode($matches[2], ENT_QUOTES | ENT_HTML5, 'UTF-8');

                return '<a href="'.e(self::normalizeHref($href)).'"'.self::renderLinkAttributes($matches[4] ?? '').'>'.$matches[1].'</a>';
            },
            $html
        );

        $html = (string) preg_replace(
            '~(?<!href=")(?<!src=")(https?://[^\s<>()]+?)([.,;:!?])?(?=\s|$)~',
            '<a href="$1">$1</a>$2',
            $html
        );

        $html = (string) preg_replace('/\*\*([^*]+)\*\*/', '<strong>$1</strong>', $html);
        $html = (string) preg_replace('/\*([^*]+)\*/', '<em>$1</em>', $html);

        return $html;
    }

    private static function normalizeHref(string $href): string
    {
        $href = trim($href);

        if (preg_match('~^(?:https?://|/|mailto:|tel:)~i', $href)) {
            return $href;
        }

        if (preg_match('~^(?:www\.)?[a-z0-9.-]+\.[a-z]{2,}~i', $href)) {
            return 'https://'.$href;
        }

        return $href;
    }

    private static function renderLinkAttributes(string $rawAttributes): string
    {
        $attributes = '';

        if (str_contains($rawAttributes, 'target=_blank')) {
            $attributes .= ' target="_blank"';
        }

        if (preg_match('/rel=([a-z,\-]+)/', $rawAttributes, $matches)) {
            $attributes .= ' rel="'.e(str_replace(',', ' ', $matches[1])).'"';
        }

        if (preg_match('/title=(?:"|&quot;)(.*?)(?:"|&quot;)/', $rawAttributes, $matches)) {
            $attributes .= ' title="'.e($matches[1]).'"';
        }

        return $attributes;
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
