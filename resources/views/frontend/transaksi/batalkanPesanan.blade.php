@extends('frontend.layouts.default')
@section('title', __( 'Pembayaran' ))
@section('content')
<style type="text/css">
	.block-newsletter form .btn {
		line-height: 40px !important;
	}
</style>
<div class="container-fluid mt-5 mb-10">
    <div class="row ">
        <div class="col-md-6">
            <h2 class="ls-n-12 mb-1 pb-2"><strong>Batalakan Pesanan</strong></h2>

            <form action="{{ URL::to('do-batalkan-pesanan') }}" method="post">
                @csrf
                <input type="hidden" name="id_transaksi" value="{{ $data->id }}">
                <div class="form-group mb-0">
                    <label for="contact-message">Alasan Pembatalan</label>
                    <textarea cols="30" rows="1" id="contact-message" class="form-control"
                        name="message" required></textarea>
                </div><!-- End .form-group -->

                <div class="form-footer">
                    <button type="submit" class="btn btn-danger" style="padding: 10px 20px; font-weight: bold; border-radius: 5px; color: #fff; background-color: #d9534f; border: none;">
                        Batalkan Pesanan
                    </button>
                </div><!-- End .form-footer -->
            </form>
        </div><!-- End .col-md-8 -->
    </div>
</div>
@endsection