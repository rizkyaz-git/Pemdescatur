<?php
$imgPath = 'C:/Users/user/.gemini/antigravity-ide/brain/ff01bf61-0d7d-4f9f-82f2-5657e33f3319/.user_uploaded/media_1788794823568.png';
if (!file_exists($imgPath)) {
    echo "File not found\n";
    exit;
}

$im = imagecreatefrompng($imgPath);
$w = imagesx($im);
$h = imagesy($im);
echo "Image dimensions: {$w}x{$h}\n";

$colors = [];
for ($x = 0; $x < $w; $x += max(1, intval($w/10))) {
    for ($y = 0; $y < $h; $y += max(1, intval($h/10))) {
        $rgb = imagecolorat($im, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        $hex = sprintf("#%02X%02X%02X", $r, $g, $b);
        $colors[$hex] = ($colors[$hex] ?? 0) + 1;
    }
}

print_r($colors);
