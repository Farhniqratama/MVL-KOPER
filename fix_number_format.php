<?php
$dirs = [
    __DIR__ . '/resources/views',
    __DIR__ . '/app/Http/Controllers'
];

$regex = '/number_format\s*\(\s*([^,]+?)(?:\s*,\s*2\s*)?\s*\)/';

foreach ($dirs as $dir) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && in_array($file->getExtension(), ['php'])) {
            $content = file_get_contents($file->getPathname());
            
            // Replace number_format($var) or number_format($var, 2)
            $newContent = preg_replace($regex, "number_format($1, 0, ',', '.')", $content);
            
            if ($content !== $newContent) {
                file_put_contents($file->getPathname(), $newContent);
                echo "Updated: " . $file->getPathname() . "\n";
            }
        }
    }
}
echo "Done.\n";
