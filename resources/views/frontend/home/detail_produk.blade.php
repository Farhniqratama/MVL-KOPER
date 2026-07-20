@extends('frontend.layouts.default')
@section('title', __( 'Detail Produk' ))
@section('content')

<!-- Page Heading Section Start -->	
<div class="pagehding-sec">
	<div class="images-overlay"></div>		
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-heading">
					<h1>shop details</h1>
				</div>
				<div class="breadcrumb-list">
					<ul>
						<li><a href="{{ URL::to('/') }}">Home</a></li>
						<li><a href="#">page</a></li>
						<li><a href="#">shop</a></li>
						<li><a href="#">shop details</a></li>
					</ul>
				</div>					
			</div>				
		</div>
	</div>
</div>
<!-- Page Heading Section End -->
<!-- Product Details Section Start -->
<div class="product-details-sec pt-100">
	<div class="container">			
		<div class="row">								
			<div class="col-md-8">								
				<div class="product-details-inner">	
					<div class="all-product-thumb">	
						@foreach($gambarProduk as $kGambar => $vGambar)
						<a href="#"><img src="{{ asset('upload/produk/'.$vGambar->gambar) }}" alt="" style="height:350px;" /></a>
						@endforeach
					</div>
					<div class="product-text">	
						<span class="product-price">Rp {{ number_format($data->harga, 0, ',', '.') }}</span>
						<div class="product-meta">
							<span class="add-to-cart"><a href="{{ URL::to('add-to-cart/'.$data->id) }}">add to cart</a></span>
							
						</div>
						<h2><a href="product-details.html">{{ $data->nama_produk }}</a></h2>
						<p>Koper eksklusif ini dirancang khusus untuk mobilitas modern. Terbuat dari material tahan banting berkualitas tinggi, koper ini memastikan keamanan barang bawaan Anda selama perjalanan. Dilengkapi dengan roda putar ganda 360 derajat yang senyap, sistem kunci kombinasi berstandar TSA, serta kompartemen interior ganda dengan pemisah jaring untuk mengatur barang bawaan tetap rapi. Nikmati perjalanan tanpa beban dengan koper premium kami.</p>							
					</div>
					<div class="product-tab-text">
						<div class="tab-content">	
							<div id="tab_1" class="tab-pane active">
								<div class="product-desc">
									<h2>Deskripsi Produk</h2>
									<p>{{ $data->deskripsi }}</p>
								</div>
							</div>	
						</div>
					</div>
				</div>	
				<div class="related-product">
					<h2>related products</h2>
					<div class="all-related-product">
						@foreach($dataProduk as $kProduk => $vProduk)
						<div class="product-inner">	
							<div class="product-thumb">	
								<a href="{{ URL::to('produk-detail/'.$vProduk->id) }}"><img src="{{ asset('upload/produk/'.$vProduk->produk_gambar) }}" alt="" style="height: 330px !important;"/></a>
							</div>
							<div class="product-text">	
								<span class="product-price">Rp {{ number_format($vProduk->harga, 0, ',', '.') }}</span>
								<h2><a href="{{ URL::to('produk-detail/'.$vProduk->id) }}">{{ $vProduk->nama_produk }}</a></h2>
								<div class="product-meta">
									<span class="add-to-cart"><a href="{{ URL::to('add-to-cart/'.$vProduk->id) }}">add to cart</a></span>
									
								</div>
							</div>
						</div>	
						@endforeach							
					</div>
				</div>					
			</div>
			<div class="col-md-4">
				<div class="sidebar">
					<div class="widget-cat">
						<h1>Kategori Produk</h1>
						<ul>
							@foreach($kategori as $kk => $vk)
							<li><a href="{{ URL::to('produk-by-kategori/'.$vk->id) }}">{{ $vk->nama_kategori }}<span></span></a></li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>				
		</div>
	</div>
</div>
<!-- Product Details Section End -->

@endsection