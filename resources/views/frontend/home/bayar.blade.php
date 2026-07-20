@extends('frontend.layouts.default')
@section('title', __( 'Pembayaran' ))
@section('content')
<style type="text/css">
	.block-newsletter form .btn {
		line-height: 40px !important;
	}
</style>
<div id="breadcrumb" class="clearfix">
	<div class="container">
		<div class="breadcrumb clearfix">
			<ul class="ul-breadcrumb">
				<li><a href="{{ URL::to('/') }}" title="Home">Home</a></li>
				<li><span>shopping cart</span></li>
			</ul>
			<h2 class="bread-title">Pemabayaran</h2>
		</div>
	</div>
</div><!-- end breadcrumb -->
<div class="section section-newsletter">
	<div class="container">
		<!-- start newsletter -->
		<div class="block-newsletter" id="block-newsletter">
			<h4 class="title_block">Pemabayaran</h4>
			<p class="descript">Silahkan Lakukan Pembayaran ke Bank BNI atas nama ANNA FLORIST ke no Rekening 123456789</p>
			<form action="{{ URL::to('do-bayar') }}" method="post" class="form-inline" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="id_transaksi" value="{{ $id_transaksi }}">
				<div class="form-group">
					<input class="inputNew form-control grey newsletter-input" id="newsletter-input" type="file" name="image" size="18" placeholder="Enter your email..." required>
					<button type="submit" name="submitNewsletter" class="btn-primary btn btn-sm">
						<span class="submit-icon"></span>
						<span class="submit-text" style="">Upload</span>
					</button>               
				</div>
			</form>
		</div><!-- end block-newsletter -->
	</div>
</div>
@endsection