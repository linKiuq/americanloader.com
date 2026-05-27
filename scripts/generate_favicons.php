<?php
$src = __DIR__ . '/../public/logo.png';
$sizes = [
    16 => __DIR__ . '/../public/favicon-16x16.png',
    32 => __DIR__ . '/../public/favicon-32x32.png',
    180 => __DIR__ . '/../public/apple-touch-icon.png',
    512 => __DIR__ . '/../public/favicon.png',
];

if (!file_exists($src)) {
    fwrite(STDERR, "Source logo not found: $src\n");
    exit(2);
}

$info = getimagesize($src);
if ($info === false) {
    fwrite(STDERR, "Could not read image info from source: $src\n");
    exit(3);
}

$mime = $info['mime'];
switch ($mime) {
    case 'image/png':
        $img = imagecreatefrompng($src);
        break;
    case 'image/jpeg':
        $img = imagecreatefromjpeg($src);
        break;
    case 'image/gif':
        $img = imagecreatefromgif($src);
        break;
    default:
        fwrite(STDERR, "Unsupported image type: $mime\n");
        exit(4);
}

if (!function_exists('imagecreatetruecolor')) {
    fwrite(STDERR, "GD functions not available in this PHP build.\n");
    exit(5);
}

foreach ($sizes as $size => $out) {
    $w = $size; $h = $size;
    $dst = imagecreatetruecolor($w, $h);
    // preserve transparency
    imagealphablending($dst, false);
    imagesavealpha($dst, true);
    $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
    imagefilledrectangle($dst, 0, 0, $w, $h, $transparent);

    $ow = imagesx($img); $oh = imagesy($img);
    $scale = min($w / $ow, $h / $oh);
    $nw = max(1, (int)($ow * $scale));
    $nh = max(1, (int)($oh * $scale));
    $dx = (int)(($w - $nw) / 2);
    $dy = (int)(($h - $nh) / 2);

    imagecopyresampled($dst, $img, $dx, $dy, 0, 0, $nw, $nh, $ow, $oh);
    imagepng($dst, $out);
    imagedestroy($dst);
    echo "Wrote: $out\n";
}

imagedestroy($img);
echo "Done.\n";
