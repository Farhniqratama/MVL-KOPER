<?php
$data = [
    [
        'nama_produk' => 'Luxe Travel Aluminium 24 inch',
        'harga' => 4500000,
    ],
    [
        'nama_produk' => 'Away Carry-On Polycarbonate',
        'harga' => 3200000,
    ],
    [
        'nama_produk' => 'Rose Gold Cabin Series',
        'harga' => 2800000,
    ],
    [
        'nama_produk' => 'Terra Expandable Spinner',
        'harga' => 2500000,
    ],
    [
        'nama_produk' => 'Pro-DLX 5 Premium',
        'harga' => 5200000,
    ],
    [
        'nama_produk' => 'Essential Cabin Matte',
        'harga' => 3900000,
    ],
];

$products = \App\Models\Produk::orderBy('id', 'asc')->get();
foreach ($products as $index => $p) {
    if (isset($data[$index])) {
        $p->harga = $data[$index]['harga'];
        $p->save();
        echo "Updated product ID {$p->id} to Rp {$p->harga}\n";
    }
}
echo "Done updating prices.\n";
