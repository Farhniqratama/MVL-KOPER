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