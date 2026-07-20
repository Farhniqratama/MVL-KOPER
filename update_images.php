<?php
$images = ['koper1.png', 'koper2.png', 'koper3.png', 'koper4.png'];

// Update GambarProduk
$gbr = App\Models\GambarProduk::all();
foreach($gbr as $key => $g) {
    $g->gambar = $images[$key % 4];
    $g->save();
}

// Update Cart (might have join issue but let's just query builder if it has a gambar field, otherwise ignore)
try {
    $carts = App\Models\Cart::all();
    foreach($carts as $key => $c) {
        $c->gambar = $images[$key % 4];
        $c->save();
    }
} catch (\Exception $e) {}

// Update Banner
$banners = App\Models\Banner::all();
foreach($banners as $key => $b) {
    try {
        $b->banner = ($key % 2 == 0) ? 'suitcase_banner_1.png' : 'suitcase_banner_2.png';
        $b->save();
    } catch (\Exception $e) {}
}

echo "Berhasil update database!\n";
