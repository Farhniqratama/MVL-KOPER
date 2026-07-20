<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Update existing products to match their names/categories
$p = \App\Models\Produk::find(2); if($p) { $p->kategori_id = 2; $p->save(); }
$p = \App\Models\Produk::find(5); if($p) { $p->kategori_id = 3; $p->save(); }
$p = \App\Models\Produk::find(6); if($p) { $p->kategori_id = 4; $p->save(); }
$p = \App\Models\Produk::find(7); if($p) { $p->kategori_id = 2; $p->save(); }

$duplicate = function($id, $cat_id, $newName, $price) {
    $p = \App\Models\Produk::find($id);
    if($p) {
        $newP = $p->replicate();
        $newP->nama_produk = $newName;
        $newP->kategori_id = $cat_id;
        $newP->harga = $price;
        $newP->kd_produk = 'KOPER' . rand(1000, 9999);
        $newP->save();
        
        // Duplicate images
        if(class_exists('\App\Models\ProdukImage')) {
            $images = \App\Models\ProdukImage::where('id_produk', $p->id)->get();
            foreach($images as $img) {
                $newImg = $img->replicate();
                $newImg->id_produk = $newP->id;
                $newImg->save();
            }
        }
    }
};

// Fill Category 2 (Medium 24")
$duplicate(3, 2, 'Away Medium Polycarbonate 24"', 3500000);
$duplicate(4, 2, 'Rose Gold Medium Series 24"', 3200000);

// Fill Category 3 (Large 28")
$duplicate(4, 3, 'Rose Gold Check-in Series 28"', 4200000);
$duplicate(2, 3, 'Luxe Travel Aluminium 28 inch', 5500000);

// Fill Category 4 (Set Koper)
$duplicate(7, 4, 'Essential Matte Family Set 3pcs', 8900000);
$duplicate(3, 4, 'Away Polycarbonate Couple Set', 6000000);

echo "Categories filled successfully.\n";
