@extends('frontend.layouts.default')
@section('title', __( 'Home' ))
@section('content')

<div class="home-slider-container">
	<div class="home-slider owl-carousel owl-theme dot-inside slide-animate" data-owl-options="{
		'dots': true,
		'nav': false,
        'autoplay': true,
        'autoplayTimeout': 5000,
        'animateOut': 'fadeOut'
	}">
		@foreach ($banner as $key => $valBanner)
        <div class="hero-section position-relative" style="height: 65vh; min-height: 450px; max-height: 650px; overflow: hidden; background: #000;">
            <!-- Background Image -->
            <div class="hero-image" style="background: url('{{ asset('uploads/banner/'.$valBanner->banner) }}') no-repeat center center; background-size: cover; position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.7; transition: transform 10s ease;"></div>
            
            <!-- Gradient Overlay for better readability -->
            <div class="hero-overlay" style="background: linear-gradient(90deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0) 100%); position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>

            <!-- Content -->
            <div class="container h-100 position-relative" style="z-index: 10;">
                <div class="row h-100 align-items-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <div class="hero-content appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="200">
                            <span class="hero-subtitle text-uppercase mb-3 d-block font-weight-bold" style="color: #f8f9fa; letter-spacing: 3px; font-size: 1rem;">Standar Baru Bepergian</span>
                            <h1 class="hero-title text-white font-weight-bolder mb-4" style="font-size: 4.5rem; line-height: 1.1; letter-spacing: -2px;">KOPER PREMIUM<br>KUALITAS DUNIA</h1>
                            <p class="hero-desc text-light mb-5" style="font-size: 1.15rem; max-width: 500px; line-height: 1.6;">Dirancang dengan presisi menggunakan bahan Polycarbonate & Aluminium untuk durabilitas maksimal dan gaya tanpa batas.</p>
                            <a href="{{ URL::to('list-produk') }}" class="btn btn-light btn-lg px-5 py-3 font-weight-bold text-uppercase hero-btn" style="border-radius: 30px; letter-spacing: 1px; color: #000; transition: all 0.3s ease;">Eksplorasi Koleksi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		@endforeach
	</div>
</div>
<style>
    .home-slider-container { margin-bottom: 2rem; }
    .hero-btn:hover { background-color: #000 !important; color: #fff !important; border-color: #000 !important; }
    /* Auto zoom effect when slide is active */
    .owl-item.active .hero-image { transform: scale(1.05); }
</style>

<div class="container mt-5 mb-5 pt-3 pb-3">
	<div class="title-group text-center mb-4">
		<h2 class="section-title text-uppercase ls-n-10">Kategori Pilihan</h2>
		<p class="text-muted">Temukan koper yang tepat untuk perjalanan Anda</p>
	</div>
	<div class="row justify-content-center">
		@foreach ($kategoriAll as $kat)
		<div class="col-6 col-md-3 mb-4">
			<a href="{{ URL::to('produk-by-kategori/'.$kat->id) }}" class="text-decoration-none">
				<div class="category-card" style="background: url('{{ asset('upload/produk/koper'.$loop->iteration.'.png') }}') no-repeat center center; background-size: cover; padding: 60px 20px; text-align: center; border-radius: 12px; transition: all 0.3s ease; border: 1px solid #eaeaea; position: relative; overflow: hidden;">
                    <div class="category-overlay" style="position: absolute; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); transition: all 0.3s ease;"></div>
					<h3 style="font-size: 18px; margin: 0; color: #fff; text-transform: uppercase; letter-spacing: 2px; position: relative; z-index: 2; font-weight: bold; text-shadow: 1px 1px 3px rgba(0,0,0,0.8);">{{ $kat->nama_kategori }}</h3>
				</div>
			</a>
		</div>
		@endforeach
	</div>
</div>

<style>
.category-card:hover {
	transform: translateY(-5px);
	box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}
.category-card:hover .category-overlay {
    background: rgba(0,0,0,0.7) !important;
}
</style>

<div class="container mt-5 mb-5">
	<div class="row align-items-center" style="background: #111; color: white; border-radius: 10px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
		<div class="col-md-6 p-5 text-center text-md-left">
			<h4 class="text-uppercase mb-2" style="color: #ccc; letter-spacing: 2px; font-size: 14px;">Penawaran Spesial</h4>
			<h2 class="mb-3" style="color: white; font-weight: 700;">PROMO AKHIR PEKAN</h2>
			<p class="mb-4" style="color: #aaa; font-size: 16px;">Dapatkan potongan harga eksklusif untuk koleksi koper Aluminium dan Polycarbonate premium kami. Persediaan terbatas!</p>
			<a href="{{ URL::to('list-produk') }}" class="btn btn-outline-light btn-lg" style="border-radius: 30px; padding: 12px 30px; letter-spacing: 1px;">LIHAT PROMO</a>
		</div>
		<div class="col-md-6 p-0">
			<!-- Using a dark/elegant suitcase placeholder pattern -->
			<div style="background: url('{{ asset('upload/produk/banner1.png') }}') no-repeat center center; background-size: cover; height: 350px; width: 100%;"></div>
		</div>
	</div>
</div>

<div class="half-section">
	<div class="d-flex flex-wrap">
		<div class="col-md-12 title-group text-center mb-2 mt-4 p-t-3">
			<h2 class="section-title text-uppercase ls-n-10">Produk Terbaru</h2>
		</div>
		<div class="col-md-6 col-12 order-md-last half-img banner banner-md-vw-small banner-5 bg-img d-flex align-items-center appear-animate" data-animation-duration="1200">
			<div class="banner-content">
				<h3 class="ls-n-10 m-b-3 text-left text-white">KOLEKSI<br />KOPER</h3>
				<p class="line-height-1 m-b-4 text-left text-white">Lihat koleksi koper terbaru kami minggu ini.</p>
				<div class="mb-0">
					<a href="{{ URL::to('list-produk') }}" class="btn btn-borders btn-lg btn-outline-light ls-10">
						BELANJA SEKARANG
					</a>
				</div>
			</div>
		</div>
		<!-- End .col-md-6 -->
		<div class="col-md-6 col-12 half-content d-flex align-items-center justify-content-center">
			<div class="products-slider owl-carousel owl-theme" data-owl-options="{
					'items': 2,
					'nav': true,
					'responsive' : {
						'576' : {
							'items' : 2
						},
						'992' : {
							'items' : 2
						}
					}
				}">
				@foreach ($produk as $valProduk)
				<div class="product-default inner-quickview inner-icon appear-animate" data-animation-name="fadeInRightShorter">
					<figure>
						<a href="{{ URl::to('produk-detail/'.$valProduk->id) }}">
							<img src="{{ asset('upload/produk/'.$valProduk->gambar) }}" alt="product" width="400" height="400" />
						</a>
						<div class="btn-icon-group">
                            <a href="{{ URL::to('add-to-cart/'.$valProduk->id) }}" class="btn-icon product-type-simple"><i class="icon-shopping-cart"></i></a>
                        </div>
					</figure>
					<div class="product-details">
						<div class="category-wrap">
							<div class="category-list">
								<a href="{{ URL::to('produk-detail/'.$valProduk->id) }}" class="product-category">{{ $valProduk->kategori }}</a>
							</div>
						</div>
						<h3 class="product-title"> <a href="{{ URl::to('produk-detail/'.$valProduk->id) }}">{{ $valProduk->nama_produk }}</a> </h3>
						<div class="ratings-container">
							<div class="product-ratings">
								<span class="ratings" style="width:0%"></span>
								<!-- End .ratings -->
								<span class="tooltiptext tooltip-top"></span>
							</div>
							<!-- End .product-ratings -->
						</div>
						<!-- End .product-container -->
						<div class="price-box">
							<span class="product-price">{{ number_format($valProduk->harga, 0, ',', '.') }}</span>
						</div>
						<!-- End .price-box -->
					</div>
					<!-- End .product-details -->
				</div>
				@endforeach
			</div>
			<!-- End .products-slider -->
		</div>
		<!-- End .col-md-6 -->
	</div>
	<!-- End .no-gutters -->
</div>
<!-- End .half-section -->
<div class="container-fluid m-b-5 p-b-3">
	<div class="products-section pt-0">
		<h2 class="section-title">Produk Terlaris</h2>

		<div class="products-slider owl-carousel owl-theme dots-top dots-small">
			@foreach ($otherProduk as $valProdukLainya)
			<div class="product-default">
				<figure>
					<a href="{{ URl::to('produk-detail/'.$valProdukLainya->id) }}">
						<img src="{{ asset('upload/produk/'.$valProdukLainya->gambar) }}" width="280" height="280" alt="product">
					</a>
				</figure>
				
				<div class="product-details">
					<div class="category-list">
						<a href="#" class="product-category">{{ $valProdukLainya->kategori }}</a>
					</div>
					<h3 class="product-title">
						<a href="{{ URl::to('produk-detail/'.$valProdukLainya->id) }}">{{ $valProdukLainya->nama_produk }}</a>
					</h3>
					<div class="ratings-container">
						<div class="product-ratings">
							<span class="ratings" style="width:80%"></span>
							<!-- End .ratings -->
							<span class="tooltiptext tooltip-top"></span>
						</div>
						<!-- End .product-ratings -->
					</div>
					<!-- End .product-container -->
					<div class="price-box">
						<span class="product-price">{{ number_format($valProdukLainya->harga, 0, ',', '.') }}</span>
					</div>
					<!-- End .price-box -->
					<div class="product-action">
						<a href="{{ URL::to('add-to-cart/'.$valProdukLainya->id) }}" class="btn-icon btn-add-cart"><i class="fa fa-arrow-right"></i><span>TAMBAH KERANJANG</span></a>
					</div>
				</div>
				<!-- End .product-details -->
			</div>
			@endforeach
		</div>
		<!-- End .products-slider -->
	</div>
</div>
<div class="container-fluid m-b-5 p-b-3">
	<div class="feature-boxes-container pb-3">
		<div class="row mt-7 mb-1">
			<div class="col-xl-3 col-sm-6 appear-animate" data-animation-delay="100" data-animation-name="fadeInUpShorter">
				<div class="feature-box px-sm-5 px-md-5 mx-sm-5 mx-md-3 feature-box-simple feature-rounded text-center h-100">
					<i class="fas fa-lock bg-dark text-white m-b-3" style="display:inline-flex; align-items:center; justify-content:center; width:60px; height:60px; border-radius:50%; font-size:24px;"></i>
					<div class="feature-box-content p-0">
						<h3 class="m-b-1 text-uppercase">TSA APPROVED</h3>
						<h5 class="font-weight-normal line-height-1 m-b-3">Keamanan Global</h5>
						<p>Dilengkapi kunci kombinasi berstandar TSA untuk kemudahan dan keamanan ekstra selama pemeriksaan bandara.</p>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 appear-animate" data-animation-delay="300" data-animation-name="fadeInUpShorter">
				<div class="feature-box px-sm-5 px-md-5 mx-sm-5 mx-md-3 feature-box-simple feature-rounded text-center h-100">
					<i class="fas fa-gem bg-dark text-white m-b-3" style="display:inline-flex; align-items:center; justify-content:center; width:60px; height:60px; border-radius:50%; font-size:24px;"></i>
					<div class="feature-box-content p-0">
						<h3 class="m-b-1 text-uppercase">MATERIAL PREMIUM</h3>
						<h5 class="font-weight-normal line-height-1 m-b-3">Awet & Tahan Lama</h5>
						<p>Dibuat dari 100% Polycarbonate dan Aluminium grade pesawat yang tangguh menahan benturan ekstrem.</p>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 appear-animate" data-animation-delay="500" data-animation-name="fadeInUpShorter">
				<div class="feature-box px-sm-5 px-md-5 mx-sm-5 mx-md-3 feature-box-simple feature-rounded text-center h-100">
					<i class="fas fa-shield-alt bg-dark text-white m-b-3" style="display:inline-flex; align-items:center; justify-content:center; width:60px; height:60px; border-radius:50%; font-size:24px;"></i>
					<div class="feature-box-content p-0">
						<h3 class="m-b-1 text-uppercase">GARANSI 10 TAHUN</h3>
						<h5 class="font-weight-normal line-height-1 m-b-3">Ketenangan Pikiran</h5>
						<p>Setiap koper dilindungi garansi pabrik hingga 10 tahun untuk kerusakan material atau roda.</p>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-sm-6 appear-animate" data-animation-delay="700" data-animation-name="fadeInUpShorter">
				<div class="feature-box px-sm-5 px-md-5 mx-sm-5 mx-md-3 feature-box-simple feature-rounded text-center h-100">
					<i class="fas fa-truck bg-dark text-white m-b-3" style="display:inline-flex; align-items:center; justify-content:center; width:60px; height:60px; border-radius:50%; font-size:24px;"></i>
					<div class="feature-box-content p-0">
						<h3 class="m-b-1 text-uppercase">PENGIRIMAN AMAN</h3>
						<h5 class="font-weight-normal line-height-1 m-b-3">Cepat & Terlindungi</h5>
						<p>Dikirim dengan bubble wrap ganda dan asuransi penuh untuk memastikan koper tiba tanpa goresan sedikitpun.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End .container-fluid -->

<!-- Brand Story Section -->
<div class="container mt-5 mb-5 pb-5 pt-5">
    <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0 appear-animate" data-animation-name="fadeInLeftShorter">
            <img src="{{ asset('upload/produk/banner2.png') }}" alt="Kisah Brand" class="img-fluid rounded" style="box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
        </div>
        <div class="col-md-6 pl-md-5 appear-animate" data-animation-name="fadeInRightShorter" data-animation-delay="200">
            <h4 class="text-uppercase mb-2" style="color: #888; letter-spacing: 2px; font-size: 13px;">Kisah Kami</h4>
            <h2 class="section-title mb-3" style="font-weight: 800; font-size: 2.5rem; line-height: 1.2;">MENDEFINISIKAN ULANG <br>GAYA BEPERGIAN</h2>
            <p class="mb-4 text-muted" style="font-size: 1.1rem; line-height: 1.8;">Berawal dari frustrasi terhadap koper yang mudah rusak, kami menciptakan lini koper eksklusif yang memadukan keindahan desain minimalis dengan ketahanan maksimal. Setiap lekukan dirancang untuk mobilitas tanpa batas.</p>
            <a href="#" class="btn btn-outline-dark btn-lg" style="border-radius: 30px; padding: 12px 35px; letter-spacing: 1px; font-weight: bold;">BACA SELENGKAPNYA</a>
        </div>
    </div>
</div>

<!-- Instagram Feed Section -->
<div class="container-fluid pt-5 mb-0 p-0 bg-white">
    <div class="title-group text-center mb-4 pt-4 appear-animate" data-animation-name="fadeInUpShorter">
        <h4 class="text-uppercase mb-2" style="color: #888; letter-spacing: 2px; font-size: 13px;">@KoperPremium</h4>
        <h2 class="section-title text-uppercase ls-n-10 mb-2">#InspirasiPerjalanan</h2>
    </div>
    
    <div class="row px-md-5 mx-md-5 appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="200">
        <div class="col-6 col-md-3 mb-4">
            <a href="#" class="instagram-item d-block position-relative overflow-hidden rounded-lg shadow-sm">
                <img src="{{ asset('upload/produk/koper1.png') }}" alt="Instagram 1" class="img-fluid" style="width: 100%; height: 300px; object-fit: cover;">
                <div class="insta-overlay d-flex align-items-center justify-content-center">
                    <i class="fab fa-instagram text-white" style="font-size: 3rem; text-shadow: 0 4px 10px rgba(0,0,0,0.3);"></i>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3 mb-4">
            <a href="#" class="instagram-item d-block position-relative overflow-hidden rounded-lg shadow-sm">
                <img src="{{ asset('upload/produk/koper2.png') }}" alt="Instagram 2" class="img-fluid" style="width: 100%; height: 300px; object-fit: cover;">
                <div class="insta-overlay d-flex align-items-center justify-content-center">
                    <i class="fab fa-instagram text-white" style="font-size: 3rem; text-shadow: 0 4px 10px rgba(0,0,0,0.3);"></i>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3 mb-4">
            <a href="#" class="instagram-item d-block position-relative overflow-hidden rounded-lg shadow-sm">
                <img src="{{ asset('upload/produk/koper3.png') }}" alt="Instagram 3" class="img-fluid" style="width: 100%; height: 300px; object-fit: cover;">
                <div class="insta-overlay d-flex align-items-center justify-content-center">
                    <i class="fab fa-instagram text-white" style="font-size: 3rem; text-shadow: 0 4px 10px rgba(0,0,0,0.3);"></i>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3 mb-4">
            <a href="#" class="instagram-item d-block position-relative overflow-hidden rounded-lg shadow-sm">
                <img src="{{ asset('upload/produk/koper4.png') }}" alt="Instagram 4" class="img-fluid" style="width: 100%; height: 300px; object-fit: cover;">
                <div class="insta-overlay d-flex align-items-center justify-content-center">
                    <i class="fab fa-instagram text-white" style="font-size: 3rem; text-shadow: 0 4px 10px rgba(0,0,0,0.3);"></i>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
.rounded-lg { border-radius: 16px !important; }
.instagram-item {
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    background: #fff;
    border: 3px solid #fff;
}
.instagram-item img {
    transition: transform 0.6s ease;
}
.instagram-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
}
.instagram-item:hover img {
    transform: scale(1.1);
}
.insta-overlay {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}
.instagram-item:hover .insta-overlay {
    opacity: 1;
}
</style>

<!-- Testimonial Section -->
<div class="container-fluid m-b-5 p-b-5 bg-white pt-5 pb-5">
    <div class="title-group text-center mb-5 appear-animate" data-animation-name="fadeInUpShorter">
        <h2 class="section-title text-uppercase ls-n-10">Ulasan Pelanggan</h2>
    </div>
    <div class="owl-carousel owl-theme appear-animate" data-animation-delay="200" data-animation-name="fadeInRightShorter" data-owl-options="{
        'items': 1,
        'margin': 20,
        'nav': false,
        'dots': true,
        'responsive': {
            '768': { 'items': 2 },
            '992': { 'items': 3 }
        }
    }">
        <div class="testimonial text-center p-4 bg-white shadow-sm" style="border-radius: 10px;">
            <p class="text-muted font-italic mb-3">"Koper aluminiumnya sangat kokoh! Bawa ke Eropa transit berkali-kali tetap mulus tanpa penyok. Sangat direkomendasikan!"</p>
            <h5 class="mb-0 font-weight-bold">- Sarah A.</h5>
        </div>
        <div class="testimonial text-center p-4 bg-white shadow-sm" style="border-radius: 10px;">
            <p class="text-muted font-italic mb-3">"Desain monokromnya elegan banget. Kabin sizenya muat banyak tapi ringan ditarik. Roda spinnernya benar-benar silent."</p>
            <h5 class="mb-0 font-weight-bold">- Michael W.</h5>
        </div>
        <div class="testimonial text-center p-4 bg-white shadow-sm" style="border-radius: 10px;">
            <p class="text-muted font-italic mb-3">"Pengiriman super aman, double box dan bubble wrap tebal. Harga set koper ini sebanding dengan kualitas brand mewah."</p>
            <h5 class="mb-0 font-weight-bold">- Rina K.</h5>
        </div>
        <div class="testimonial text-center p-4 bg-white shadow-sm" style="border-radius: 10px;">
            <p class="text-muted font-italic mb-3">"Garansi 10 tahunnya memberikan rasa aman. Customer service sangat responsif membalas pertanyaan lewat fitur chat."</p>
            <h5 class="mb-0 font-weight-bold">- David J.</h5>
        </div>
    </div>
</div>

<!-- Newsletter Section -->
<div class="container mt-5 mb-5 pb-4">
    <div class="row appear-animate" data-animation-name="fadeInUpShorter" style="background: #000; border-radius: 15px; padding: 60px 30px; box-shadow: 0 15px 40px rgba(0,0,0,0.2);">
        <div class="col-md-8 mx-auto text-center text-white">
            <h3 class="text-white text-uppercase font-weight-bold mb-3" style="letter-spacing: 1px;">Klub Elite Kami</h3>
            <p class="mb-4 text-light" style="font-size: 16px;">Berlangganan newsletter kami dan jadilah yang pertama mendapatkan info diskon eksklusif serta rilis koper edisi terbatas.</p>
            <form action="#" class="d-flex justify-content-center" onsubmit="event.preventDefault(); alert('Terima kasih telah berlangganan!');" style="height: 50px;">
                <input type="email" class="form-control mr-3 h-100" placeholder="Masukkan alamat email Anda" style="max-width: 350px; border-radius: 30px; padding: 0 25px; border: none; margin: 0;">
                <button type="submit" class="btn btn-light text-uppercase font-weight-bold h-100 d-flex align-items-center justify-content-center" style="border-radius: 30px; padding: 0 30px; letter-spacing: 1px; border: none; margin: 0;">BERLANGGANAN</button>
            </form>
        </div>
    </div>
</div>

@endsection