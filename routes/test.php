<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Route::get('/test-purifier', function () {
    $html1 = '<img src="/storage/news/content/image.jpg" alt="test">';
    $html2 = '<img src="http://PemdesCatur.test/storage/news/content/image.jpg" alt="test">';
    $html3 = '<img src="data:image/png;base64,123" alt="test">';
    
    return [
        'relative' => App\Helpers\HtmlPurifierHelper::clean($html1),
        'absolute' => App\Helpers\HtmlPurifierHelper::clean($html2),
        'base64' => App\Helpers\HtmlPurifierHelper::clean($html3),
    ];
});
