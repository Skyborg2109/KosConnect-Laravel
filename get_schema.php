<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(Illuminate\Http\Request::capture());

use Illuminate\Support\Facades\DB;

$columns = DB::select('DESCRIBE kamar');
$output = "";
foreach ($columns as $column) {
    $output .= print_r($column, true) . "\n";
}
file_put_contents('schema_log.txt', $output);
echo "Schema written to schema_log.txt\n";
