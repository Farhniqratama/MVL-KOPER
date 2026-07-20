<?php
$files = [
    'public/parfume/assets/css/demo6.min.css',
    'public/parfume/assets/css/style.min.css'
];

foreach ($files as $file) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        $content = file_get_contents($path);
        // Replace lowercase
        $content = str_replace('#f4f4f4', '#ffffff', $content);
        // Replace uppercase just in case
        $content = str_replace('#F4F4F4', '#ffffff', $content);
        
        file_put_contents($path, $content);
        echo "Updated colors in: $file\n";
    } else {
        echo "File not found: $file\n";
    }
}
