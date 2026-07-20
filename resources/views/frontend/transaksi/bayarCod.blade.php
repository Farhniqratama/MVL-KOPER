@extends('frontend.layouts.default')
@section('title', __( 'Pembayaran' ))
@section('content')
<style type="text/css">
	.block-newsletter form .btn {
		line-height: 40px !important;
	}
</style>
<div class="section section-newsletter mt-7" style="justify-self:center;">
	<div class="container">
		<!-- start newsletter -->
		<div class="block-newsletter mb-2" id="block-newsletter">
			<h4 class="title_block">Pembayaran</h4>
			<p class="descript">Silahkan Lakukan Pembayaran ke kurir pada saat produk anda sudah sampai</p>
            <img src="{{ asset('assets/images/cod.png') }}" alt="" style="width:300px;justify-self:center;">
            <a href="{{ URL::to('histori-transaksi') }}" class="btn btn-primary">Kembali</a>
		</div><!-- end block-newsletter -->
	</div>
</div>
@endsection