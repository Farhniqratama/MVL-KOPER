@extends('frontend.layouts.default')
@section('title', __( 'Home' ))
@section('content')

<!-- Page Heading Section Start -->	
<div class="pagehding-sec">
	<div class="images-overlay"></div>		
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-heading">
					<h1>shop</h1>
				</div>
				<div class="breadcrumb-list">
					<ul>
						<li><a href="{{ URL::to('/') }}">Home</a></li>
						<li><a href="#">shop</a></li>
					</ul>
				</div>					
			</div>				
		</div>
	</div>
</div>
<!-- Page Heading Section End -->	

<!-- Product Section Start -->
<div class="product-sec pt-100 pb-70">
	<div class="container">		
		<div class="row">	
			@foreach($dataProduk as $key => $value)			
			<div class="col-md-3 col-sm-12">				
				<div class="product-inner">	
					<div class="product-thumb">	
						<a href="{{ URL::to('produk-detail/'.$value->id) }}"><img src="{{ asset('upload/produk/'.$value->produk_gambar) }}" alt="" style="height: 345px !important;"></a>
						<div class="product-thumb-overlay">
							<a href="{{ URL::to('add-to-cart/'.$value->id) }}">Add To Cart</a>
						</div>
					</div>
					<div class="product-text">	
						<span class="product-price" style="font-size: 20px !important;">Rp {{ number_format($value->harga, 0, ',', '.') }}</span>
						<h2><a href="{{ URL::to('produk-detail/'.$value->id) }}" style="font-size: 14px !important;">{{ $value->nama_produk }}</a></h2>
					</div>
				</div>
			</div>	
			@endforeach
		</div>
	</div>
</div>
<!-- Product Section End -->	

@endsection