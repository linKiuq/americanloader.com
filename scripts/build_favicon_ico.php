<?php
$png = __DIR__ . '/../public/favicon-32x32.png';
$ico = __DIR__ . '/../public/favicon.ico';

if (!file_exists($png)) {
    fwrite(STDERR, "Source PNG not found: $png\n");
    exit(1);
}

$data = file_get_contents($png);
if ($data === false) {
    fwrite(STDERR, "Failed to read PNG data.\n");
    exit(2);
}

$pngSize = strlen($data);

// ICONDIR header: 2 bytes reserved, 2 bytes type (1 for ICO), 2 bytes count
$iconDir = pack('vvv', 0, 1, 1);

// ICONDIRENTRY: width(1), height(1), colorCount(1), reserved(1), planes(2), bitcount(2), bytesInRes(4), imageOffset(4)
$width = 32;
$height = 32;
$colorCount = 0;
$reserved = 0;
$planes = 0; // when PNG inside ICO set to 0
$bitCount = 0; // when PNG inside ICO set to 0
$bytesInRes = $pngSize;
$imageOffset = 6 + 16; // header (6) + one directory entry (16)
$entry = pack('CCCCvvVV', $width, $height, $colorCount, $reserved, $planes, $bitCount, $bytesInRes, $imageOffset);

$icoData = $iconDir . $entry . $data;

if (file_put_contents($ico, $icoData) === false) {
    fwrite(STDERR, "Failed to write $ico\n");
    exit(3);
}

echo "Wrote favicon.ico (size: " . filesize($ico) . ")\n";
