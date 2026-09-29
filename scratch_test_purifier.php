<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$testHtml = '<p>Halo ini teks</p><p><img src="http://PemdesCatur.test/storage/news/content/I2JtDEGq0jLmWCXh8Y6KJuPCssJjqBcN85WoGuHC.jpg" alt="test"></p>';
$cleaned = App\Helpers\HtmlPurifierHelper::clean($testHtml);

echo "INPUT:  " . $testHtml . PHP_EOL;
echo "CLEAN:  " . $cleaned . PHP_EOL;
