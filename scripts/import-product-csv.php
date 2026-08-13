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
    $images = correctedProductImages($sku, $images);
    $checkoutUrl = str_replace(['/store/#!/', '/store#!/'], '/store/', trim($row[$column['External URL']]));
    $salePrice = numericPrice($row[$column['Sale price']]);
    $regularPrice = numericPrice($row[$column['Regular price']]);
    $summary = productSummary($name, $category, $subcategory, $sku);

    $products[] = [
        'id' => isset($column['ID']) ? (int) $row[$column['ID']] : 0,
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
        'desc' => $summary['short'],
        'fullDesc' => $summary['text'],
        'fullDescHtml' => $summary['html'],
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
    $value = normalizeEscapedLineBreaks($value);
    $text = html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');

    return trim((string) preg_replace('/\s+/u', ' ', $text));
}

function cleanDescriptionHtml(string $value): string
{
    $value = normalizeEscapedLineBreaks($value);
    $html = strip_tags($value, '<p><br><strong><em><ul><ol><li><h1><h2><h3><h4><table><thead><tbody><tr><th><td>');
    $html = preg_replace_callback(
        '/<(\/?)(p|br|strong|em|ul|ol|li|h1|h2|h3|h4|table|thead|tbody|tr|th|td)\b[^>]*>/i',
        static function (array $match): string {
            $tag = strtolower($match[2]) === 'h1' ? 'h2' : strtolower($match[2]);

            return '<'.$match[1].$tag.'>';
        },
        $html
    );
    $html = preg_replace('/<(p|li|h2|h3|h4)>\s*(?:<br>\s*)?<\/\1>/i', '', (string) $html);
    $html = preg_replace('/<br>\s*<\/p>/i', '</p>', (string) $html);
    $html = preg_replace('/<p>\s*<\/p>/i', '', (string) $html);
    $html = preg_replace('/>\s+</', ">\n<", (string) $html);
    $html = str_ireplace(["<p>\n<br>\n</p>", '<p><br></p>', '<p></p>'], '', (string) $html);

    return trim((string) $html);
}

function normalizeEscapedLineBreaks(string $value): string
{
    return str_replace(['\\r\\n', '\\n', '\\r'], "\n", $value);
}

function numericPrice(string $value): ?float
{
    $value = trim($value);

    return $value !== '' && is_numeric($value) ? (float) $value : null;
}

function productSummary(string $name, string $category, string $subcategory, string $sku): array
{
    $profiles = [
        'Mini Excavators' => [
            'purpose' => 'a compact digging machine for contractors, property owners, landscapers, and utility crews',
            'work' => 'trenching, grading, drainage work, site preparation, landscaping, and material handling',
            'selection' => 'operating weight, engine configuration, digging requirements, access width, and attachment compatibility',
            'value' => 'Its compact format can help crews work around buildings, established landscaping, narrow access points, and other locations where a larger excavator may be difficult to position.',
            'ownership' => 'Plan for routine inspection of the tracks, pins, bushings, hydraulic connections, fluids, and working attachments to support dependable daily operation.',
        ],
        'Skid Steer Loaders' => [
            'purpose' => 'a maneuverable loader for construction, landscaping, agriculture, and property maintenance',
            'work' => 'loading, grading, clearing, moving bulk material, and working in space-restricted areas',
            'selection' => 'rated capacity, operating weight, engine type, travel system, hydraulic flow, and attachment requirements',
            'value' => 'A compact loader can reduce manual handling while giving one operator a practical platform for changing between multiple site tasks and compatible attachments.',
            'ownership' => 'Regular checks of the undercarriage or tires, hydraulic connections, controls, fluids, and attachment interface should be included in the operating routine.',
        ],
        'Wheel Loaders' => [
            'purpose' => 'a material-handling machine for yards, farms, warehouses, construction sites, and commercial properties',
            'work' => 'loading aggregate, moving soil or supplies, stockpile management, cleanup, and general yard work',
            'selection' => 'lifting capacity, engine or power system, machine dimensions, site conditions, and attachment compatibility',
            'value' => 'The loader layout is intended to combine useful material capacity with maneuverability for repeated loading cycles and movement between work areas.',
            'ownership' => 'Inspect the articulation points, tires, loader arms, hydraulic lines, fluids, and attachment coupler regularly, particularly when the machine works on abrasive or uneven surfaces.',
        ],
        'Forklifts' => [
            'purpose' => 'a material-handling solution for warehouses, distribution facilities, workshops, and production environments',
            'work' => 'pallet movement, loading and unloading, inventory handling, and routine indoor material transport',
            'selection' => 'rated lift capacity, mast height, battery and charging needs, aisle width, and operating environment',
            'value' => 'Its compact material-handling format is useful where predictable maneuvering, controlled pallet placement, and efficient indoor travel are important to daily operations.',
            'ownership' => 'Confirm charging facilities and establish routine checks for the forks, mast, hydraulic system, tires, controls, battery condition, and safety equipment.',
        ],
        'Road Rollers' => [
            'purpose' => 'a compact compaction machine for contractors, landscapers, repair crews, and property projects',
            'work' => 'compacting soil, gravel, asphalt repairs, paths, driveways, trenches, and foundation preparation',
            'selection' => 'drum dimensions, operating weight, vibration system, surface type, and jobsite access',
            'value' => 'A compact roller offers a practical way to improve surface consistency in areas where larger compaction equipment would be unnecessary or difficult to maneuver.',
            'ownership' => 'Routine care should cover the drum, vibration components, scraper bars, controls, fluid levels, engine or power system, and any signs of loose hardware.',
        ],
        'Scissor Lifts' => [
            'purpose' => 'an elevated work platform for maintenance, installation, inspection, and facility tasks',
            'work' => 'overhead access, electrical work, signage, warehouse maintenance, construction finishing, and equipment servicing',
            'selection' => 'platform height, load rating, machine width, power source, floor conditions, and indoor or outdoor use',
            'value' => 'The vertical-lift design provides a stable working platform for tasks that require tools and materials to be raised together while maintaining a compact footprint.',
            'ownership' => 'Operators should follow the applicable inspection procedure for the platform, guardrails, controls, emergency systems, tires, battery or power system, and lifting mechanism.',
        ],
        'Mini Excavator Attachments' => [
            'purpose' => 'an attachment intended to expand the working capability of compatible compact excavators',
            'work' => 'digging, grading, demolition, material handling, land clearing, or other specialized jobsite operations',
            'selection' => 'machine weight class, pin and mount dimensions, hydraulic requirements, hose connections, and intended application',
            'value' => 'Choosing a task-specific attachment can make one excavator more productive and reduce the need to bring a separate machine to the work area.',
            'ownership' => 'Inspect pins, bushings, welds, cutting or working edges, hoses, fittings, and fasteners before use, and follow the carrier machine limits throughout operation.',
        ],
        'Skid Steer Attachments' => [
            'purpose' => 'an attachment designed to give compatible skid steer loaders added jobsite versatility',
            'work' => 'material handling, grading, clearing, digging, landscaping, agriculture, or site cleanup',
            'selection' => 'loader series, mounting interface, hydraulic flow, operating capacity, dimensions, and intended task',
            'value' => 'A correctly matched attachment can turn the loader into a more flexible tool carrier and shorten changeover time between common site operations.',
            'ownership' => 'Check the coupler engagement, hydraulic hoses, fittings, welds, wear surfaces, fasteners, and moving components before each work period.',
        ],
        'SKOOP Attachments' => [
            'purpose' => 'a purpose-built attachment for compatible TYPHON SKOOP wheel loaders',
            'work' => 'handling pallets, logs, brush, supplies, and other materials across yards, farms, and jobsites',
            'selection' => 'loader compatibility, mounting points, hydraulic flow, attachment dimensions, load requirements, and intended material',
            'value' => 'The dedicated SKOOP fitment supports efficient attachment changes and gives the loader a more specialized role for recurring handling work.',
            'ownership' => 'Inspect the mounting interface, hydraulic connections, frame, forks or gripping components, pivot points, and fasteners before operation.',
        ],
    ];

    $profile = $profiles[$category] ?? [
        'purpose' => 'a practical equipment solution for commercial and property-maintenance work',
        'work' => 'construction, landscaping, agriculture, material handling, and general jobsite operations',
        'selection' => 'machine compatibility, capacity, dimensions, power requirements, and intended use',
        'value' => 'The configuration is intended to help reduce manual work and provide a repeatable approach to common site tasks.',
        'ownership' => 'Follow the manufacturer inspection and maintenance guidance and check all working, safety, and connection points before operation.',
    ];
    $variants = [
        ['positioned as', 'It is suited to', 'Before ordering, confirm'],
        ['configured as', 'Typical applications include', 'To choose the correct setup, review'],
        ['offered as', 'This configuration can support', 'Purchase planning should account for'],
        ['designed as', 'Its practical uses include', 'Compatibility should be checked against'],
    ];
    $variant = $variants[abs(crc32($sku ?: $name)) % count($variants)];
    $context = $subcategory !== '' && $subcategory !== $category
        ? " It is listed in the {$subcategory} range."
        : '';

    $paragraphs = [
        "The {$name} is {$variant[0]} {$profile['purpose']}.{$context} Its product configuration provides a focused option for buyers comparing equipment for regular professional or property use.",
        "{$variant[1]} {$profile['work']}. {$profile['value']} The model name highlights its principal configuration, making it easier to compare with other options in the {$category} range and narrow the selection for a specific type of work.",
        "A productive setup depends on matching the equipment to the material, ground conditions, available working space, transport plan, and expected duty cycle. Operators should use the machine within its rated limits, complete a pre-start inspection, and follow the manufacturer guidance for safe operation. {$profile['ownership']}",
        "{$variant[2]} {$profile['selection']}. Also verify the advertised specifications, connection requirements, included components, delivery configuration, and suitability for your machine or worksite before purchase. Product photos may show optional items or a particular configuration, so the final package should be confirmed when ordering.",
        "American Loader can help review the intended application and identify questions that should be resolved before purchase. Contact the equipment team for current details, availability, or fitment assistance for catalog reference {$sku}.",
    ];
    $text = implode(' ', $paragraphs);

    return [
        'short' => Str::limit($paragraphs[0].' '.$paragraphs[1], 320),
        'text' => $text,
        'html' => '<h2>Product Overview</h2>' . "\n"
            . '<p>'.htmlspecialchars($paragraphs[0], ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8').'</p>' . "\n"
            . '<h2>Applications and Everyday Use</h2>' . "\n"
            . '<p>'.htmlspecialchars($paragraphs[1], ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8').'</p>' . "\n"
            . '<p>'.htmlspecialchars($paragraphs[2], ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8').'</p>' . "\n"
            . '<h2>Choosing the Right Configuration</h2>' . "\n"
            . '<p>'.htmlspecialchars($paragraphs[3], ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8').'</p>' . "\n"
            . '<p>'.htmlspecialchars($paragraphs[4], ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8').'</p>',
    ];
}

function correctedProductImages(string $sku, array $images): array
{
    $corrections = [
        'TYPH-8007' => [
            'https://d2j6dbq0eux0bg.cloudfront.net/images/80100025/products/843668254/5836129613.jpg',
            'https://d2j6dbq0eux0bg.cloudfront.net/images/80100025/products/843668254/5836138069.jpg',
            'https://d2j6dbq0eux0bg.cloudfront.net/images/80100025/products/843668254/5836129601.jpg',
            'https://d2j6dbq0eux0bg.cloudfront.net/images/80100025/products/843668254/5836129595.jpg',
            'https://d2j6dbq0eux0bg.cloudfront.net/images/80100025/products/843668254/5836138075.jpg',
        ],
        'TYPH-8005' => [
            'https://d2j6dbq0eux0bg.cloudfront.net/images/80100025/products/843665003/5836138008.jpg',
            'https://d2j6dbq0eux0bg.cloudfront.net/images/80100025/products/843665003/5836129516.jpg',
            'https://d2j6dbq0eux0bg.cloudfront.net/images/80100025/products/843665003/5836129522.jpg',
            'https://d2j6dbq0eux0bg.cloudfront.net/images/80100025/products/843665003/5836129510.jpg',
            'https://d2j6dbq0eux0bg.cloudfront.net/images/80100025/products/843665003/5836129528.jpg',
        ],
    ];

    return $corrections[$sku] ?? $images;
}

function mapCategory(string $path): array
{
    $paths = array_values(array_filter(array_map('trim', explode(',', $path))));
    $allowedEquipment = ['Forklifts', 'Mini Excavators', 'Road Rollers', 'Scissor Lifts', 'Skid Steer Loaders', 'Wheel Loaders'];

    foreach ($paths as $categoryPath) {
        $parts = array_values(array_filter(array_map('trim', explode('>', $categoryPath))));

        if (($parts[0] ?? '') === 'Equipment' && count($parts) > 1) {
            $leaf = $parts[count($parts) - 1];

            if (in_array($leaf, $allowedEquipment, true)) {
                return [$leaf, $leaf];
            }
        }
    }

    $attachmentPaths = array_values(array_filter(
        $paths,
        static fn (string $categoryPath): bool => str_starts_with($categoryPath, 'Attachments >')
            || str_starts_with($categoryPath, 'Attachment & Parts >')
    ));
    usort($attachmentPaths, static fn (string $a, string $b): int => substr_count($b, '>') <=> substr_count($a, '>'));

    foreach ($attachmentPaths as $categoryPath) {
        $parts = array_values(array_filter(array_map('trim', explode('>', $categoryPath))));
        $leaf = $parts[count($parts) - 1] ?? '';

        if (str_contains($categoryPath, 'Mini Excavator Attachments') || str_contains($categoryPath, 'Attachments for Mini Excavators')) {
            return ['Mini Excavator Attachments', $leaf];
        }

        if (strcasecmp($leaf, 'Skoop Attachments') === 0) {
            return ['SKOOP Attachments', 'SKOOP Attachments'];
        }

        if (str_contains($categoryPath, 'Skid Steer Attachments')) {
            return ['Skid Steer Attachments', $leaf];
        }
    }

    throw new RuntimeException("Unsupported product category: {$path}");
}
