<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST URL ACCESS ===" . PHP_EOL;
$url = 'http://pemdescatur.test/storage/news/content/I2JtDEGq0jLmWCXh8Y6KJuPCssJjqBcN85WoGuHC.jpg';
echo "Testing URL: " . $url . PHP_EOL;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "HTTP Status: " . $httpCode . PHP_EOL;
if ($error) {
    echo "Error: " . $error . PHP_EOL;
} else {
    echo "Response: " . substr($response, 0, 200) . PHP_EOL;
}

echo PHP_EOL . "=== TEST FILE EXISTS ===" . PHP_EOL;
$filePath = storage_path('app/public/news/content/I2JtDEGq0jLmWCXh8Y6KJuPCssJjqBcN85WoGuHC.jpg');
echo "Storage path: " . $filePath . PHP_EOL;
echo "File exists: " . (file_exists($filePath) ? 'YES' : 'NO') . PHP_EOL;

$publicPath = public_path('storage/news/content/I2JtDEGq0jLmWCXh8Y6KJuPCssJjqBcN85WoGuHC.jpg');
echo "Public path: " . $publicPath . PHP_EOL;
echo "File exists in public: " . (file_exists($publicPath) ? 'YES' : 'NO') . PHP_EOL;

echo PHP_EOL . "=== TEST SYMLINK ===" . PHP_EOL;
$symlinkPath = public_path('storage');
echo "Symlink path: " . $symlinkPath . PHP_EOL;
echo "Is link: " . (is_link($symlinkPath) ? 'YES' : 'NO') . PHP_EOL;
echo "Is dir: " . (is_dir($symlinkPath) ? 'YES' : 'NO') . PHP_EOL;
echo "Target: " . (is_link($symlinkPath) ? readlink($symlinkPath) : 'N/A') . PHP_EOL;

// Check if it's a junction (Windows)
if (is_dir($symlinkPath) && !is_link($symlinkPath)) {
    echo "Note: This is a Windows Junction, not a symlink" . PHP_EOL;
    echo "Directory contents:" . PHP_EOL;
    $items = scandir($symlinkPath);
    foreach ($items as $item) {
        if ($item !== '.' && $item !== '..') {
            echo "  - " . $item . PHP_EOL;
        }
    }
}
