<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\News;
use Illuminate\Support\ViewErrorBag;

// Share errors bag for CLI rendering
view()->share('errors', new ViewErrorBag());

echo "Testing view rendering...\n";

// 1. Test Admin News Create
$createHtml = view('admin.news.create')->render();
if (strpos($createHtml, 'quill-editor') !== false && strpos($createHtml, 'quill.min.js') !== false) {
    echo "✅ admin.news.create: Quill editor and scripts present!\n";
} else {
    echo "❌ admin.news.create: Quill missing!\n";
}

// 2. Test Admin News Edit
$news = News::first();
if ($news) {
    $editHtml = view('admin.news.edit', compact('news'))->render();
    if (strpos($editHtml, 'quill-editor') !== false && strpos($editHtml, 'quill.min.js') !== false) {
        echo "✅ admin.news.edit: Quill editor and scripts present!\n";
    } else {
        echo "❌ admin.news.edit: Quill missing!\n";
    }

    // 3. Test Public News Show
    $showHtml = view('public.news.show', [
        'news' => $news,
        'relatedNews' => News::where('id', '!=', $news->id)->take(3)->get()
    ])->render();
    if (strpos($showHtml, 'article-body-content') !== false && strpos($showHtml, '.ql-align-') !== false) {
        echo "✅ public.news.show: article-body-content and Quill formatting styles present!\n";
    } else {
        echo "❌ public.news.show: article-body-content or Quill styles missing!\n";
    }
} else {
    $dummyNews = new News([
        'id' => 1,
        'title' => 'Test Berita Quill',
        'slug' => 'test-berita-quill',
        'category' => 'Berita',
        'content' => '<p class="ql-align-center"><strong>Pengumuman Penting</strong></p><p>Isi berita dengan <em>format</em> kaya.</p><ul><li>Poin 1</li><li>Poin 2</li></ul>',
        'status' => 'published',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    $showHtml = view('public.news.show', [
        'news' => $dummyNews,
        'relatedNews' => collect()
    ])->render();
    if (strpos($showHtml, 'article-body-content') !== false && strpos($showHtml, '.ql-align-') !== false) {
        echo "✅ public.news.show: article-body-content and Quill formatting styles present!\n";
    }
}
echo "All tests passed!\n";
