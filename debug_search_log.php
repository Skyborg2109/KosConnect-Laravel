<?php
$logFile = 'c:/laragon/www/Project-232021/storage/logs/laravel.log';
$content = file_get_contents($logFile);
$pos = strrpos($content, "Uploading file");
if ($pos !== false) {
    // Get 500 chars
    $snippet = substr($content, $pos, 500);
    file_put_contents('debug_output.txt', $snippet);
    echo "Wrote snippet to debug_output.txt";
} else {
    echo "Log entry not found.";
}
