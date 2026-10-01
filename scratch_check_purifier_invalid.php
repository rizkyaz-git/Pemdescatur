<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$html = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=" alt="Test Alt Image" width="100" height="100">';
echo "Result Base64: " . App\Helpers\HtmlPurifierHelper::clean($html) . PHP_EOL;

$html2 = '<img src="javascript:alert(1)" alt="Test Alt Javascript" width="100" height="100">';
echo "Result JS: " . App\Helpers\HtmlPurifierHelper::clean($html2) . PHP_EOL;

$html3 = '<img src="invalid-uri" alt="Test Alt Invalid" width="100" height="100">';
echo "Result Invalid: " . App\Helpers\HtmlPurifierHelper::clean($html3) . PHP_EOL;
