$file = 'c:/laragon/www/Project-232021/vendor/cloudinary-labs/cloudinary-laravel/src/CloudinaryServiceProvider.php';
$lines = file($file);
$output = "";
for ($i = 40; $i <= 100; $i++) {
    $output .= ($i + 1) . ': ' . trim($lines[$i] ?? '') . "\n";
}
file_put_contents('debug_vendor_source.txt', $output);
echo "Output written to debug_vendor_source.txt";
