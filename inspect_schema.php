<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Columns in kos table:\n";
$columns = \Illuminate\Support\Facades\Schema::getColumnListing('kos');
foreach ($columns as $col) {
    echo "- " . $col . "\n";
}
