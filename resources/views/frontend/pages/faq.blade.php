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