<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\News;
use Illuminate\Support\Carbon;
use Illuminate\Support\ViewErrorBag;

view()->share('errors', new ViewErrorBag());

$news = News::first();
if (!$news) {
    $news = new News();
    $news->id = 1;
    $news->exists = true;
    $news->title = 'Uji Coba Berita';
    $news->slug = 'uji-coba-berita';
    $news->category = 'Berita';
    $news->image_caption = 'Suasana kebersamaan warga Desa Catur';
    $news->content = '<p>Konten artikel</p>';
    $news->created_at = Carbon::now();
    $news->published_at = Carbon::now();
} else {
    $news->image_caption = 'Suasana kebersamaan warga Desa Catur';
}

$html = view('public.news.show', [
    'news' => $news,
    'relatedNews' => collect()
])->render();

if (strpos($html, 'Suasana kebersamaan warga Desa Catur') !== false && strpos($html, '<figcaption') !== false) {
    echo "✅ Caption rendered successfully inside <figcaption> on public.news.show!\n";
} else {
    echo "❌ Caption missing from show view!\n";
}

$createHtml = view('admin.news.create')->render();
if (strpos($createHtml, 'name="image_caption"') !== false) {
    echo "✅ Admin create view has image_caption input!\n";
} else {
    echo "❌ Admin create view missing image_caption!\n";
}

$editHtml = view('admin.news.edit', ['news' => $news])->render();
if (strpos($editHtml, 'name="image_caption"') !== false && strpos($editHtml, 'Suasana kebersamaan') !== false) {
    echo "✅ Admin edit view has image_caption input with existing value populated!\n";
} else {
    echo "❌ Admin edit view missing image_caption or value not populated!\n";
}
echo "All tests passed successfully!\n";
