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
		<div class="block-newsletter" id="block-newsletter">
			<h4 class="title_block">Pembayaran</h4>
			<p class="descript">Silahkan Lakukan Pembayaran dengan scan Qris dibawah ini dan upload bukti pembayaran anda</p>
            <img src="{{ asset('images/qris.jpeg') }}" alt="" style="width:300px;justify-self:center;">
			<form action="{{ URL::to('do-bayar') }}" method="post" class="form-inline mt-2" enctype="multipart/form-data" style="justify-self:center;">
				@csrf
				<input type="hidden" name="id_transaksi" value="{{ $id_transaksi }}">
				<div class="form-group" >
					<input class="inputNew form-control grey newsletter-input" id="newsletter-input" type="file" name="image" size="18" placeholder="Enter your email..." required>
					<button type="submit" name="submitNewsletter" class="btn btn-dark" style="padding: 10px 20px; font-weight: bold; border-radius: 5px; color: #fff; background-color: #333; border: none; margin-left: 10px;">
						<i class="fa fa-upload" style="margin-right: 5px;"></i> Upload
					</button> 
				</div>
			</form>
		</div><!-- end block-newsletter -->
	</div>
</div>
@endsection