<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$html1 = '<img src="/storage/news/content/image.jpg" alt="test">';
$html2 = '<img src="news/content/image.jpg" alt="test">';
$html3 = '<img src="https://example.com/storage/news/content/image.jpg" alt="test">';

echo "Result 1: " . App\Helpers\HtmlPurifierHelper::clean($html1) . PHP_EOL;
echo "Result 2: " . App\Helpers\HtmlPurifierHelper::clean($html2) . PHP_EOL;
echo "Result 3: " . App\Helpers\HtmlPurifierHelper::clean($html3) . PHP_EOL;
