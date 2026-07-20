<?php
$pages = [
    'tentang-kami' => 'Tentang Kami',
    'hubungi-kami' => 'Hubungi Kami',
    'garansi' => 'Garansi 10 Tahun',
    'kebijakan-pengembalian' => 'Kebijakan Pengembalian',
    'faq' => 'Pertanyaan yang Sering Diajukan (FAQ)',
    'lacak-pengiriman' => 'Lacak Pengiriman',
    'keuntungan-member' => 'Keuntungan Member'
];

$dir = __DIR__ . '/resources/views/frontend/pages';
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

foreach ($pages as $file => $title) {
    $content = "@extends('frontend.layouts.default')\n";
    $content .= "@section('title', '$title')\n";
    $content .= "@section('content')\n";
    $content .= "<main class=\"main\">\n";
    $content .= "    <div class=\"page-header\" style=\"background-color: #f9f9f9; padding: 60px 0; text-align: center;\">\n";
    $content .= "        <div class=\"container\">\n";
    $content .= "            <h1 class=\"text-uppercase\" style=\"font-weight: 800; letter-spacing: 2px;\">$title</h1>\n";
    $content .= "        </div>\n";
    $content .= "    </div>\n";
    $content .= "    <div class=\"container mt-5 mb-5 pt-3 pb-5\">\n";
    $content .= "        <div class=\"row\">\n";
    $content .= "            <div class=\"col-md-8 mx-auto text-center\">\n";
    if ($file == 'hubungi-kami') {
        $content .= "                <p class=\"lead mb-5\" style=\"color: #666;\">Kami selalu siap membantu Anda. Silakan hubungi kami melalui saluran resmi di bawah ini.</p>\n";
        $content .= "                <div class=\"row text-center mt-5\">\n";
        $content .= "                    <div class=\"col-md-4 mb-4\"><i class=\"fab fa-whatsapp mb-3\" style=\"font-size: 40px; color: #25D366;\"></i><h4 class=\"text-uppercase\" style=\"font-size: 14px; font-weight: 700;\">WhatsApp</h4><p class=\"text-muted\">0877-1681-6892</p></div>\n";
        $content .= "                    <div class=\"col-md-4 mb-4\"><i class=\"fas fa-envelope mb-3\" style=\"font-size: 40px; color: #333;\"></i><h4 class=\"text-uppercase\" style=\"font-size: 14px; font-weight: 700;\">Email</h4><p class=\"text-muted\">info@rendykoper.com</p></div>\n";
        $content .= "                    <div class=\"col-md-4 mb-4\"><i class=\"fas fa-map-marker-alt mb-3\" style=\"font-size: 40px; color: #E4405F;\"></i><h4 class=\"text-uppercase\" style=\"font-size: 14px; font-weight: 700;\">Alamat</h4><p class=\"text-muted\">Jakarta, Indonesia 2026</p></div>\n";
        $content .= "                </div>\n";
    } else {
        $content .= "                <i class=\"fas fa-tools mb-4\" style=\"font-size: 50px; color: #ddd;\"></i>\n";
        $content .= "                <h3 class=\"mb-3\">Halaman Sedang Dibuat</h3>\n";
        $content .= "                <p style=\"color: #666; line-height: 1.8;\">Halaman <strong>$title</strong> saat ini sedang dalam proses penyusunan konten oleh tim kami. Informasi eksklusif mengenai layanan ini akan segera tersedia dalam waktu dekat. Terima kasih atas pengertian dan kesabaran Anda.</p>\n";
        $content .= "                <p style=\"color: #666;\">Jika Anda memiliki pertanyaan mendesak, jangan ragu untuk <a href=\"{{ url('hubungi-kami') }}\" class=\"text-dark font-weight-bold\">menghubungi layanan pelanggan kami</a> yang siap membantu 24/7.</p>\n";
        $content .= "                <a href=\"{{ url('/') }}\" class=\"btn btn-dark mt-4\" style=\"border-radius: 30px; padding: 10px 30px;\">KEMBALI KE BERANDA</a>\n";
    }
    $content .= "            </div>\n";
    $content .= "        </div>\n";
    $content .= "    </div>\n";
    $content .= "</main>\n";
    $content .= "@endsection\n";
    file_put_contents("$dir/$file.blade.php", $content);
}
echo "Pages created successfully.\n";
