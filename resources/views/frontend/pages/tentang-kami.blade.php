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