@extends('frontend.layouts.default')
@section('title', __( 'Checkout' ))
@section('content')
<style type="text/css">
	.update-cart-right input[type=submit] {
	    background: #4cc700 none repeat scroll 0 0;
	    color: #fff;
	    display: inline-block;
	    font-weight: bold;
	    padding: 14px 30px;
	    text-transform: capitalize;
	    font-size: 14px;
	}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Page Heading Section Start -->	
	<div class="pagehding-sec">
		<div class="images-overlay"></div>		
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="page-heading">
						<h1>checkout</h1>
					</div>
					<div class="breadcrumb-list">
						<ul>
							<li><a href="{{ URL::to('/') }}">Home</a></li>
							<li><a href="#">shop</a></li>
							<li><a href="#">cart</a></li>
							<li><a href="#">checkout</a></li>
						</ul>
					</div>					
				</div>				
			</div>
		</div>
	</div>
	<!-- Page Heading Section End -->	

<div class="cart-page-sec pt-100 pb-100">
	<!-- container -->
	<div class="container">
		<div class="row">
			<div class="checkoutleft col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<form action="{{ URL::to('do-checkout') }}" id="formaddress" method="post" class="form-horizontal">
					@csrf
					<div class="panel-group" id="accordion">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
										Alamat Pengiriman
									</a>
								</h4>
							</div>
							<div id="collapseOne" class="accordion-body collapse in">
								<div class="panel-body">
									
										<div class="form-group">
											<div class="col-md-12">
												<label>Nama Lengkap</label>
												<input type="hidden" name="pelanggan_id" value="{{ $detailData->id }}">
												<input type="text" name="nama_lengkap" value="{{ $detailData->nama }}" required class="form-control">
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-12">
												<label>No Telephone</label>
												<input type="text" name="no_telp" value="{{ $detailData->no_telp }}" required class="form-control">
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-12">
												<label>Provinsi</label>
												<select class="form-control" name="provinsi_id" id="provinsi_id" required onchange="fetchCities(this.value)">
													<option value="">-- Pilih Provinsi --</option>
													@foreach($provinsi as $vp)
													<option value="{{ $vp->id }}" @if(!empty($alamat)) @if($alamat->provinsi_id == $vp->id) selected @endif @endif>{{ $vp->province_name }}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-12">
												<label>Kota </label>
												<select id="city" name="kota_id" class="form-control" required>
										            <option value="">-- Pilih Kota --</option>
										            @if(!empty($alamat))
										            @foreach($kota as $kp => $vp)
													<option value="{{ $vp->id }}" @if(!empty($alamat)) @if($alamat->kota_id == $vp->id) selected @endif @endif>{{ $vp->name }}</option>
													@endforeach
										            @endif
										        </select>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-12">
												<label>Alamat Lengkap </label>
												<input type="text" name="alamat_lengkap" value="@if(!empty($alamat)) {{ $alamat->alamat_lengkap }} @endif" class="form-control" required>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-12">
												<label>Kode Pos </label>
												<input type="text" name="kode_pos" value="@if(!empty($alamat)) {{ $alamat->kode_pos }} @endif" class="form-control" required>
											</div>
										</div>
									
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
										Pembayaran
									</a>
								</h4>
							</div>
							<div id="collapseThree" class="accordion-body collapse">
								<div class="panel-body">
									<table class="table table-bordered shop_tablecart">
										<thead>
											<tr>
												<th class="product-thumbnail text-center">
													Produk
												</th>
												<th class="product-name">
													Deskripsi
												</th>
												<th class="product-name text-right">
													Harga
												</th>
												<th class="product-quantity text-center">
													Quantity
												</th>
												<th class="product-subtotal text-right">
													Total
												</th>
											</tr>
										</thead>
										<tbody>
											@php $total = 0; @endphp
											@foreach($dataCart as $kd => $vd)
											@php $total += $vd->harga * $vd->qty; @endphp
											<input type="hidden" name="produk_id[]" value="{{ $vd->produk_id }}">
											<input type="hidden" name="harga[]" value="{{ $vd->harga }}">
											<input type="hidden" name="id_cart[]" value="{{ $vd->id }}">
											<input type="hidden" name="qty[]" value="{{ $vd->qty }}">
											<tr class="cart_table_item">
												<td class="product-thumbnail text-center">
													<a href="page-detail.html">
														<img width="80" height="107" alt="" class="img-responsive" src="{{ asset('upload/produk/'.$vd->gambar_produk) }}">
													</a>
												</td>
												<td class="product-name">
													<a href="page-detail.html">{{ $vd->nama_produk }}</a>
												</td>
												<td class="product-price text-right">
													<span class="amount">{{ number_format($vd->harga, 0, ',', '.') }}</span>
												</td>
												<td class="product-quantity text-center">
													{{ number_format($vd->qty, 0, ',', '.') }}
												</td>
												<td class="product-subtotal text-right">
													<span class="amount">{{ number_format($vd->harga * $vd->qty, 0, ',', '.') }}</span>
												</td>
											</tr>
											@endforeach
										</tbody>
										<tfoot>
											<tr>
												<th colspan="4">Total</th>
												<th class="product-subtotal text-right">{{ number_format($total, 0, ',', '.') }}</th>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
					</div>

					<div class="actions-continue pull-right update-cart-right">
						<input type="hidden" name="total_pembayaran" value="{{ $total }}">
						<button type="submit" class="btn btn-primary" name="proceed" style="padding: 14px 30px; font-weight: bold; text-transform: capitalize; color: #fff; border: none;">Buat Pesanan <i class="fa fa-arrow-right"></i></button>
					</div>
				</form>
			</div>
		</div>
	</div> <!-- end container -->
</div><!--end columns -->
<script>
    function fetchCities(provinceID) {
        if(provinceID) {
            $.ajax({
                url: "{{ url('getCity') }}/" + provinceID,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('#city').empty();
                    $('#city').append('<option value="">-- Pilih Kota --</option>');
                    $.each(data, function(key, value) {
                        $('#city').append('<option value="'+ value.id +'">'+ value.city_name +'</option>');
                    });
                },
                error:function(err) {
                    console.log("Gagal memuat kota", err);
                }
            });
        } else {
            $('#city').empty();
            $('#city').append('<option value="">-- Pilih Kota --</option>');
        }
    }
</script>
@endsection