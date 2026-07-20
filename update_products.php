<?php
$data = [
    [
        'nama_produk' => 'Luxe Travel Aluminium 24 inch',
        'deskripsi' => 'Koper aluminium kelas premium dengan desain elegan dan durabilitas tinggi. Dilengkapi dengan kunci ganda TSA, roda ganda 360 derajat untuk mobilitas mulus, dan interior luas. Sangat cocok untuk perjalanan bisnis maupun liburan mewah.'
    ],
    [
        'nama_produk' => 'Away Carry-On Polycarbonate',
        'deskripsi' => 'Koper kabin berbahan polikarbonat ringan dan anti-pecah. Menawarkan kompartemen cerdas yang memisahkan pakaian bersih dan kotor. Roda senyap dan pegangan teleskopik memberikan kenyamanan maksimal saat bepergian.'
    ],
    [
        'nama_produk' => 'Rose Gold Cabin Series',
        'deskripsi' => 'Koper kabin dengan warna rose gold yang memukau. Dibuat dari material polikarbonat yang kuat dan tahan goresan. Dilengkapi dengan kunci kombinasi TSA dan interior elegan berlapis kain premium.'
    ],
    [
        'nama_produk' => 'Terra Expandable Spinner',
        'deskripsi' => 'Koper berukuran sedang yang bisa diekspansi (expandable) untuk kapasitas ekstra. Material kokoh, desain ramping, dilengkapi kantong-kantong tersembunyi yang sangat praktis. Teman sempurna untuk petualangan alam maupun kota.'
    ],
    [
        'nama_produk' => 'Pro-DLX 5 Premium',
        'deskripsi' => 'Koper bisnis legendaris dengan organisasi interior terbaik. Dilengkapi dengan kompartemen cerdas anti guncangan, material balistik yang tangguh, dan kunci keamanan mutakhir. Mewakili gaya profesional masa kini.'
    ],
    [
        'nama_produk' => 'Essential Cabin Matte',
        'deskripsi' => 'Ikon dari koper modern. Koper ini menyatukan keindahan desain minimalis dan fungsi mekanis tingkat tinggi. Kunci TSA terintegrasi dan sistem multiwheel memberikan pengalaman tanpa hambatan di setiap bandara.'
    ],
];

$products = \App\Models\Produk::orderBy('id', 'asc')->get();
foreach ($products as $index => $p) {
    if (isset($data[$index])) {
        $p->nama_produk = $data[$index]['nama_produk'];
        $p->deskripsi = $data[$index]['deskripsi'];
        $p->save();
        echo "Updated product ID {$p->id} to {$p->nama_produk}\n";
    }
}
echo "Done updating products.\n";
