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