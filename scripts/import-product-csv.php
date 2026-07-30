<?php

declare(strict_types=1);

use Illuminate\Support\Str;

require dirname(__DIR__).'/vendor/autoload.php';

$source = $argv[1] ?? null;
$destination = $argv[2] ?? dirname(__DIR__).'/public/equipment-products.json';

if (! is_string($source) || ! is_file($source)) {
    fwrite(STDERR, "Usage: php scripts/import-product-csv.php <source.csv> [destination.json]\n");
    exit(1);
}

$handle = fopen($source, 'rb');

if ($handle === false) {
    throw new RuntimeException("Unable to open CSV: {$source}");
}

$headers = fgetcsv($handle, null, ',', '"', '\\');

if ($headers === false) {
    throw new RuntimeException('The CSV is empty.');
}

$column = array_flip($headers);
$required = ['Name', 'Published', 'Short description', 'Description', 'Sale price', 'Regular price', 'Categories', 'Images', 'External URL', 'Button text', 'SKU'];

foreach ($required as $name) {
    if (! array_key_exists($name, $column)) {
        throw new RuntimeException("Missing required CSV column: {$name}");
    }
}

$products = [];
$seenSlugs = [];
$line = 1;

while (($row = fgetcsv($handle, null, ',', '"', '\\')) !== false) {
    $line++;

    if (count($row) !== count($headers)) {
        throw new RuntimeException("Invalid column count on CSV record ending near line {$line}.");
    }

    if (trim($row[$column['Published']]) !== '1') {
        continue;
    }

    $name = cleanText($row[$column['Name']]);
    $categoryPath = cleanText($row[$column['Categories']]);
    [$category, $subcategory] = mapCategory($categoryPath);
    $sku = cleanText($row[$column['SKU']]);
    $slug = Str::slug($name);

    if ($name === '' || $slug === '') {
        throw new RuntimeException("Missing product name near line {$line}.");
    }

    if (isset($seenSlugs[$slug])) {
        $slug .= '-'.Str::slug($sku);
    }

    if (isset($seenSlugs[$slug])) {
        throw new RuntimeException("Duplicate product slug and SKU combination '{$slug}' near line {$line}.");
    }

    $seenSlugs[$slug] = true;
    $images = array_values(array_filter(array_map(
        static fn (string $image): string => trim($image),
        explode(',', $row[$column['Images']])
    )));
    $checkoutUrl = str_replace(['/store/#!/', '/store#!/'], '/store/', trim($row[$column['External URL']]));
    $salePrice = numericPrice($row[$column['Sale price']]);
    $regularPrice = numericPrice($row[$column['Regular price']]);

    $products[] = [
        'name' => $name,
        'slug' => $slug,
        'sku' => $sku,
        'price' => $salePrice ?? $regularPrice ?? 0,
        'category' => $category,
        'subcategory' => $subcategory,
        'categoryPath' => $categoryPath,
        'image' => $images[0] ?? null,
        'images' => $images,
        'hash' => $checkoutUrl,
        'checkoutUrl' => $checkoutUrl,
        'detailUrl' => '/product/'.$slug,
        'desc' => cleanText($row[$column['Short description']]),
        'fullDesc' => cleanText($row[$column['Description']]),
        'fullDescHtml' => cleanDescriptionHtml($row[$column['Description']]),
        'buttonText' => cleanText($row[$column['Button text']]) ?: 'BUY NOW',
    ];
}

fclose($handle);

$json = json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);

if (file_put_contents($destination, $json.PHP_EOL) === false) {
    throw new RuntimeException("Unable to write catalog: {$destination}");
}

fwrite(STDOUT, sprintf("Imported %d products into %s\n", count($products), $destination));

function cleanText(string $value): string
{
    $text = html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');

    return trim((string) preg_replace('/\s+/u', ' ', $text));
}

function cleanDescriptionHtml(string $value): string
{
    $html = strip_tags($value, '<p><br><strong><em><ul><ol><li><h1><h2><h3><h4><table><thead><tbody><tr><th><td>');
    $html = preg_replace_callback(
        '/<(\/?)(p|br|strong|em|ul|ol|li|h1|h2|h3|h4|table|thead|tbody|tr|th|td)\b[^>]*>/i',
        static function (array $match): string {
            $tag = strtolower($match[2]) === 'h1' ? 'h2' : strtolower($match[2]);

            return '<'.$match[1].$tag.'>';
        },
        $html
    );

    return trim((string) $html);
}

function numericPrice(string $value): ?float
{
    $value = trim($value);

    return $value !== '' && is_numeric($value) ? (float) $value : null;
}

function mapCategory(string $path): array
{
    $parts = array_values(array_filter(array_map('trim', explode('>', $path))));
    $root = $parts[0] ?? '';
    $leaf = $parts[count($parts) - 1] ?? '';

    if ($root === 'Equipment') {
        $allowed = ['Forklifts', 'Mini Excavators', 'Road Rollers', 'Scissor Lifts', 'Skid Steer Loaders', 'Wheel Loaders'];

        if (! in_array($leaf, $allowed, true)) {
            throw new RuntimeException("Unsupported equipment category: {$path}");
        }

        return [$leaf, $leaf];
    }

    if ($root === 'Attachment & Parts' || $root === 'Attachments') {
        if (str_contains($path, 'Attachments for Mini Excavators')) {
            return ['Mini Excavator Attachments', $leaf];
        }

        if (strcasecmp($leaf, 'Skoop Attachments') === 0) {
            return ['SKOOP Attachments', 'SKOOP Attachments'];
        }

        if (str_contains($path, 'Skid Steer Attachments')) {
            return ['Skid Steer Attachments', $leaf];
        }
    }

    throw new RuntimeException("Unsupported product category: {$path}");
}
