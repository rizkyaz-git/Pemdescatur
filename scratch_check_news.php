<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$news = App\Models\News::all();
echo "Total news: " . $news->count() . PHP_EOL;
foreach ($news as $n) {
    echo "ID: " . $n->id . " | Title: " . $n->title . PHP_EOL;
    echo "Content: " . $n->content . PHP_EOL;
    echo "-----------------------------------" . PHP_EOL;
}
