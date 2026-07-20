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