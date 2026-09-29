<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

echo "=== STORAGE CONFIG ===" . PHP_EOL;
echo "APP_URL: " . config('app.url') . PHP_EOL;
echo "Public disk URL: " . config('filesystems.disks.public.url') . PHP_EOL;
echo "Public disk root: " . config('filesystems.disks.public.root') . PHP_EOL;
echo PHP_EOL;

echo "=== TEST UPLOAD ===" . PHP_EOL;
// Use existing image from storage
$sourcePath = storage_path('app/public/news/sawah_irigasi.png');
echo "Source exists: " . (file_exists($sourcePath) ? 'YES' : 'NO') . PHP_EOL;

if (file_exists($sourcePath)) {
    $file = new UploadedFile($sourcePath, 'sawah_irigasi.png', 'image/png', null, true);
    $path = $file->store('news/content', 'public');
    echo "Stored path: " . $path . PHP_EOL;
    echo "Storage URL: " . Storage::disk('public')->url($path) . PHP_EOL;
    echo "File exists in storage: " . (Storage::disk('public')->exists($path) ? 'YES' : 'NO') . PHP_EOL;

    // Check if file is accessible via public path
    $publicPath = public_path('storage/' . $path);
    echo "Public path: " . $publicPath . PHP_EOL;
    echo "File exists in public: " . (file_exists($publicPath) ? 'YES' : 'NO') . PHP_EOL;

    // Check symlink
    echo "Symlink exists: " . (is_link(public_path('storage')) ? 'YES' : 'NO') . PHP_EOL;
    if (is_link(public_path('storage'))) {
        echo "Symlink target: " . readlink(public_path('storage')) . PHP_EOL;
    }
}

echo PHP_EOL . "=== TEST URL GENERATION ===" . PHP_EOL;
echo "asset('storage/news/test.jpg'): " . asset('storage/news/test.jpg') . PHP_EOL;
echo "Storage::url('news/test.jpg'): " . Storage::disk('public')->url('news/test.jpg') . PHP_EOL;

echo PHP_EOL . "=== TEST HTML PURIFIER ===" . PHP_EOL;
$testHtml = '<p>Test</p><img src="http://PemdesCatur.test/storage/news/content/test.jpg" alt="test">';
$cleaned = App\Helpers\HtmlPurifierHelper::clean($testHtml);
echo "Original: " . $testHtml . PHP_EOL;
echo "Cleaned: " . $cleaned . PHP_EOL;
echo "Img src preserved: " . (str_contains($cleaned, 'src="http://PemdesCatur.test/storage/news/content/test.jpg"') ? 'YES' : 'NO') . PHP_EOL;
