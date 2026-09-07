<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$details = App\Models\PpkoProgramDetail::orderBy('urutan')->get();
foreach ($details as $d) {
    echo "=== {$d->aspek} ===\n";
    echo "RAW JSON: " . json_encode($d->keterangan) . "\n";
}
