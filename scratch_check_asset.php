<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Asset URL: " . asset('storage/test.jpg') . "\n";
echo "Config APP_URL: " . config('app.url') . "\n";
echo "Config ASSET_URL: " . config('app.asset_url') . "\n";
