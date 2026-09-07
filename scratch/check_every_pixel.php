<?php
$imgPath = 'C:/Users/user/.gemini/antigravity-ide/brain/ff01bf61-0d7d-4f9f-82f2-5657e33f3319/.user_uploaded/media_1788794823568.png';
$im = imagecreatefrompng($imgPath);
$w = imagesx($im);
$h = imagesy($im);
$diff = 0;
$colors = [];
for ($x = 0; $x < $w; $x++) {
    for ($y = 0; $y < $h; $y++) {
        $rgb = imagecolorat($im, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        $hex = sprintf("#%02X%02X%02X", $r, $g, $b);
        $colors[$hex] = ($colors[$hex] ?? 0) + 1;
    }
}
print_r($colors);
