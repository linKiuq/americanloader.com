<?php

namespace App\Support;

use Illuminate\Support\Str;
use Illuminate\Support\HtmlString;

class BlogContent
{
    public static function markdown(string $content): HtmlString
    {
        return Str::markdown(self::convertBareImageUrls($content));
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
}
