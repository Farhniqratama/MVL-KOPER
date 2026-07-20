<?php
$dir = __DIR__ . '/resources/views/frontend/pages';

// 1. Tentang Kami
$tentangKami = <<<HTML
@extends('frontend.layouts.default')
@section('title', 'Tentang Kami - Rendy Koper')
@section('content')
<main class="main">
    <div class="page-header bg-dark text-white" style="padding: 80px 0; text-align: center; background: url('https://images.unsplash.com/photo-1551524164-687a55dd1126?auto=format&fit=crop&q=80&w=2000') center/cover no-repeat; position: relative;">
        <div style="position: absolute; top:0; left:0; right:0; bottom:0; background: rgba(0,0,0,0.6);"></div>
        <div class="container" style="position: relative; z-index: 2;">
            <h1 class="text-uppercase" style="font-weight: 800; letter-spacing: 2px;">Cerita Kami</h1>
        </div>
    </div>
    <div class="container mt-5 mb-5 pt-3 pb-5">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4">
                <h3 class="mb-4 text-uppercase" style="font-weight: 700;">Mendefinisikan Ulang Perjalanan</h3>
                <p style="color: #666; line-height: 1.8; font-size: 15px;">Berdiri pada tahun 2024, Rendy Koper hadir dengan visi sederhana: memberikan koper premium berkualitas tinggi dengan harga yang masuk akal. Kami percaya bahwa teman perjalanan terbaik Anda adalah koper yang tangguh, elegan, dan dapat diandalkan di segala medan.</p>
                <p style="color: #666; line-height: 1.8; font-size: 15px;">Setiap koper kami dirancang dengan ketelitian tingkat tinggi, menggunakan material Polycarbonate murni dan Aluminium kelas penerbangan. Kami tidak hanya menjual koper, kami memberikan jaminan kenyamanan di setiap langkah perjalanan Anda.</p>
            </div>
            <div class="col-md-6 mb-4">
                <img src="https://images.unsplash.com/photo-1590845947376-2638caa89309?auto=format&fit=crop&q=80&w=800" alt="Tentang Kami" class="img-fluid rounded shadow-lg">
            </div>
        </div>
    </div>
</main>
@endsection
HTML;
file_put_contents("$dir/tentang-kami.blade.php", $tentangKami);

// 2. Garansi 10 Tahun
$garansi = <<<HTML
@extends('frontend.layouts.default')
@section('title', 'Garansi 10 Tahun')
@section('content')
<main class="main">
    <div class="page-header" style="background-color: #000; color: #fff; padding: 60px 0; text-align: center;">
        <div class="container">
            <h1 class="text-uppercase" style="font-weight: 800; letter-spacing: 2px;">Garansi Terbatas 10 Tahun</h1>
        </div>
    </div>
    <div class="container mt-5 mb-5 pt-3 pb-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="text-center mb-5">
                    <i class="fas fa-shield-alt" style="font-size: 60px; color: #000;"></i>
                </div>
                <h4 class="mb-3 text-uppercase font-weight-bold">Komitmen Kualitas Kami</h4>
                <p style="color: #666; line-height: 1.8; font-size: 15px;">Rendy Koper memberikan jaminan garansi fungsional selama 10 tahun terhitung dari tanggal pembelian. Garansi ini mencakup kerusakan pada komponen vital seperti:</p>
                <ul style="color: #666; line-height: 1.8; font-size: 15px;" class="mb-4">
                    <li>Retak atau pecah pada cangkang koper akibat kesalahan pabrik (bukan akibat pemakaian kasar/maskapai penerbangan).</li>
                    <li>Roda yang macet, patah, atau terlepas.</li>
                    <li>Troli (gagang tarikan) yang tidak bisa ditarik atau rusak.</li>
                    <li>Ritsleting yang jebol atau lepas jalurnya.</li>
                    <li>Kunci kombinasi TSA yang tidak berfungsi semestinya.</li>
                </ul>
                <h4 class="mb-3 text-uppercase font-weight-bold">Apa Yang Tidak Ditanggung?</h4>
                <p style="color: #666; line-height: 1.8; font-size: 15px;">Garansi tidak mencakup kerusakan kosmetik akibat pemakaian wajar (seperti goresan, lecet, warna pudar), serta kerusakan ekstrem yang terbukti diakibatkan oleh kelalaian pihak ketiga (misal: maskapai penerbangan atau ekspedisi).</p>
                <a href="{{ url('hubungi-kami') }}" class="btn btn-dark mt-3 text-uppercase font-weight-bold" style="border-radius: 0; padding: 12px 30px;">Klaim Garansi</a>
            </div>
        </div>
    </div>
</main>
@endsection
HTML;
file_put_contents("$dir/garansi.blade.php", $garansi);

// 3. Kebijakan Pengembalian
$pengembalian = <<<HTML
@extends('frontend.layouts.default')
@section('title', 'Kebijakan Pengembalian')
@section('content')
<main class="main">
    <div class="page-header" style="background-color: #000; color: #fff; padding: 60px 0; text-align: center;">
        <div class="container">
            <h1 class="text-uppercase" style="font-weight: 800; letter-spacing: 2px;">Kebijakan Pengembalian (100 Hari)</h1>
        </div>
    </div>
    <div class="container mt-5 mb-5 pt-3 pb-5">
        <div class="row">
            <div class="col-md-8 mx-auto text-center">
                <i class="fas fa-undo-alt mb-4" style="font-size: 50px; color: #000;"></i>
                <h3 class="mb-3 text-uppercase font-weight-bold">Coba Selama 100 Hari</h3>
                <p style="color: #666; line-height: 1.8; font-size: 15px;">Kami ingin Anda benar-benar yakin dengan koper yang Anda beli. Oleh karena itu, kami memberikan kebijakan pengembalian dalam waktu 100 hari penuh (tanpa banyak tanya).</p>
                <p style="color: #666; line-height: 1.8; font-size: 15px;" class="mb-4">Jika dalam kurun waktu 100 hari Anda merasa koper ini tidak sesuai dengan ekspektasi, Anda dapat mengembalikannya untuk mendapatkan <strong>pengembalian dana 100%</strong>.</p>
                
                <h4 class="mt-5 mb-3 text-uppercase font-weight-bold">Syarat & Ketentuan Pengembalian</h4>
                <ul class="text-left mx-auto" style="color: #666; line-height: 1.8; font-size: 15px; max-width: 600px;">
                    <li>Produk harus dikembalikan beserta seluruh aksesoris asli (sarung debu, tag, dan kotak kardus).</li>
                    <li>Produk belum pernah digunakan untuk bepergian jauh (kondisi roda dan cangkang tidak boleh ada baret/tanda pemakaian di luar ruangan).</li>
                    <li>Biaya pengiriman kembali ditanggung oleh pihak pembeli.</li>
                </ul>
            </div>
        </div>
    </div>
</main>
@endsection
HTML;
file_put_contents("$dir/kebijakan-pengembalian.blade.php", $pengembalian);

// 4. FAQ
$faq = <<<HTML
@extends('frontend.layouts.default')
@section('title', 'FAQ')
@section('content')
<main class="main">
    <div class="page-header" style="background-color: #000; color: #fff; padding: 60px 0; text-align: center;">
        <div class="container">
            <h1 class="text-uppercase" style="font-weight: 800; letter-spacing: 2px;">Pusat Bantuan (FAQ)</h1>
        </div>
    </div>
    <div class="container mt-5 mb-5 pt-3 pb-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="accordion" id="faqAccordion">
                    
                    <!-- FAQ 1 -->
                    <div class="card mb-3 border-0 shadow-sm" style="border-radius: 8px;">
                        <div class="card-header bg-white" id="headingOne" style="border-radius: 8px;">
                            <h5 class="mb-0">
                                <button class="btn btn-link text-dark font-weight-bold text-decoration-none w-100 text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true">
                                    <i class="fas fa-chevron-right mr-2 text-muted" style="font-size:12px;"></i> Bagaimana cara mengatur ulang sandi gembok TSA?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseOne" class="collapse show" data-parent="#faqAccordion">
                            <div class="card-body" style="color: #666; line-height: 1.8;">
                                Secara *default*, sandi kunci TSA Anda adalah `0-0-0`. Untuk mengubahnya: 
                                <br>1. Posisikan angka di `0-0-0`. 
                                <br>2. Tekan tombol *reset* kecil dengan ujung pena hingga berbunyi "klik".
                                <br>3. Putar angka ke kombinasi baru yang Anda inginkan.
                                <br>4. Tekan tombol pembuka (geser tombol besar). Tombol *reset* akan kembali ke posisi semula. Sandi Anda berhasil diatur.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="card mb-3 border-0 shadow-sm" style="border-radius: 8px;">
                        <div class="card-header bg-white" id="headingTwo" style="border-radius: 8px;">
                            <h5 class="mb-0">
                                <button class="btn btn-link text-dark font-weight-bold text-decoration-none w-100 text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false">
                                    <i class="fas fa-chevron-right mr-2 text-muted" style="font-size:12px;"></i> Berapa lama waktu pengiriman pesanan?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" data-parent="#faqAccordion">
                            <div class="card-body" style="color: #666; line-height: 1.8;">
                                Untuk area Jabodetabek, pengiriman memakan waktu 1-3 hari kerja. Untuk luar pulau Jawa, estimasi pengiriman adalah 3-7 hari kerja tergantung dari ekspedisi yang dipilih.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="card mb-3 border-0 shadow-sm" style="border-radius: 8px;">
                        <div class="card-header bg-white" id="headingThree" style="border-radius: 8px;">
                            <h5 class="mb-0">
                                <button class="btn btn-link text-dark font-weight-bold text-decoration-none w-100 text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false">
                                    <i class="fas fa-chevron-right mr-2 text-muted" style="font-size:12px;"></i> Apakah koper ukuran 20" masuk ke dalam kabin pesawat?
                                </button>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse" data-parent="#faqAccordion">
                            <div class="card-body" style="color: #666; line-height: 1.8;">
                                Ya, semua koper ukuran 20" kami telah dirancang sesuai dengan standar *International Air Transport Association* (IATA) dan dipastikan muat di semua kabin maskapai penerbangan komersial internasional maupun domestik.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection
HTML;
file_put_contents("$dir/faq.blade.php", $faq);

// 5. Lacak Pengiriman
$lacak = <<<HTML
@extends('frontend.layouts.default')
@section('title', 'Lacak Pengiriman')
@section('content')
<main class="main">
    <div class="page-header" style="background-color: #000; color: #fff; padding: 60px 0; text-align: center;">
        <div class="container">
            <h1 class="text-uppercase" style="font-weight: 800; letter-spacing: 2px;">Lacak Pesanan Anda</h1>
        </div>
    </div>
    <div class="container mt-5 mb-5 pt-5 pb-5">
        <div class="row">
            <div class="col-md-6 mx-auto text-center">
                <i class="fas fa-box-open mb-4" style="font-size: 50px; color: #000;"></i>
                <p class="mb-4" style="color: #666; line-height: 1.8;">Masukkan Nomor Resi pengiriman Anda di bawah ini untuk melihat status paket secara real-time.</p>
                <form action="#" onsubmit="event.preventDefault(); alert('Sistem pelacakan sedang terhubung ke kurir, mohon tunggu sebentar...');">
                    <div class="input-group mb-3 shadow-sm" style="border-radius: 8px; overflow: hidden;">
                        <input type="text" class="form-control" placeholder="Contoh: RNDY123456789" style="padding: 25px 20px; border: 1px solid #eee;">
                        <div class="input-group-append">
                            <button class="btn btn-dark text-uppercase font-weight-bold px-4" type="submit">LACAK PAKET</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
HTML;
file_put_contents("$dir/lacak-pengiriman.blade.php", $lacak);

// 6. Keuntungan Member
$member = <<<HTML
@extends('frontend.layouts.default')
@section('title', 'Keuntungan Member')
@section('content')
<main class="main">
    <div class="page-header" style="background-color: #000; color: #fff; padding: 60px 0; text-align: center;">
        <div class="container">
            <h1 class="text-uppercase" style="font-weight: 800; letter-spacing: 2px;">Rendy Koper Elite Club</h1>
        </div>
    </div>
    <div class="container mt-5 mb-5 pt-3 pb-5">
        <div class="row text-center">
            <div class="col-12 mb-5">
                <p class="lead" style="color: #666;">Bergabunglah dengan keanggotaan eksklusif kami dan dapatkan fasilitas yang tidak didapatkan oleh pembeli biasa.</p>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4 border rounded shadow-sm h-100" style="background: #fff;">
                    <i class="fas fa-percent mb-4" style="font-size: 40px; color: #000;"></i>
                    <h5 class="text-uppercase font-weight-bold">Diskon Selamanya</h5>
                    <p style="color: #666; font-size: 14px; line-height: 1.8;">Dapatkan otomatis potongan harga sebesar 10% untuk semua pembelian produk tanpa batas minimum belanja.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4 border rounded shadow-sm h-100" style="background: #fff;">
                    <i class="fas fa-birthday-cake mb-4" style="font-size: 40px; color: #000;"></i>
                    <h5 class="text-uppercase font-weight-bold">Kejutan Ulang Tahun</h5>
                    <p style="color: #666; font-size: 14px; line-height: 1.8;">Kami memberikan *Voucher* rahasia spesial khusus untuk Anda pada bulan ulang tahun Anda.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4 border rounded shadow-sm h-100" style="background: #fff;">
                    <i class="fas fa-plane-departure mb-4" style="font-size: 40px; color: #000;"></i>
                    <h5 class="text-uppercase font-weight-bold">Akses Awal (Early Access)</h5>
                    <p style="color: #666; font-size: 14px; line-height: 1.8;">Beli koleksi edisi terbatas (*Limited Edition*) lebih dulu sebelum dirilis ke publik luas.</p>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="{{ url('register-user') }}" class="btn btn-dark text-uppercase font-weight-bold" style="padding: 15px 40px; border-radius: 30px; letter-spacing: 1px;">DAFTAR SEKARANG - GRATIS</a>
        </div>
    </div>
</main>
@endsection
HTML;
file_put_contents("$dir/keuntungan-member.blade.php", $member);

echo "Pages populated successfully.\n";
