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
        <div class="col-md-12">
            <h2 class="ls-n-12 mb-1 pb-2"><strong>Retur Pesanan</strong></h2>
            <span style="color:red;">Tolong sertakan Video atau Foto Produk</span>
            <form action="{{ URL::to('do-retur-pesanan') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_transaksi" value="{{ $data->id }}">
                <div class="form-group mb-0">
                    <label for="contact-message">Video/Foto</label>
                    <input type="file" name="image" class="form-control" required>
                </div><!-- End .form-group -->
                <div class="form-group mb-0">
                    <label for="contact-message">Alasan Retur</label>
                    <textarea cols="30" rows="1" id="contact-message" class="form-control"
                        name="message" required></textarea>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-warning" style="padding: 10px 20px; font-weight: bold; border-radius: 5px; color: #fff; background-color: #f0ad4e; border: none;">
                        Retur Pesanan
                    </button>
                </div><!-- End .form-footer -->
            </form>
        </div><!-- End .col-md-8 -->
    </div>
</div>
@endsection