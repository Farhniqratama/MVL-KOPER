@extends('frontend.layouts.default')
@section('title', __( 'Cart' ))
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
<!-- Page Heading Section Start -->	
<div class="pagehding-sec">
	<div class="images-overlay"></div>		
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-heading">
					<h1>Cart</h1>
				</div>
				<div class="breadcrumb-list">
					<ul>
						<li><a href="{{ URL::to('/') }}">Home</a></li>
						<li><a href="#">shop</a></li>
						<li><a href="#">Cart</a></li>
					</ul>
				</div>					
			</div>				
		</div>
	</div>
</div>
<!-- Page Heading Section End -->	

<!-- Cart Page Section Start -->
<div class="cart-page-sec pt-100">
	<div class="container">			
		<div class="row">								
			<div class="cart-page">	
				<form method="post" action="{{ URL::to('update-cart') }}">
				@csrf										
					<div class="table-text table-responsive">
						<table class="table table-responsive">
							<thead>
								<tr>
									<th class="product-img">Gambar</th>
									<th class="product-name">Nama Produk</th>
									<th class="product-quantity">qantity</th>
									<th class="product-price">Harga</th>
									<th class="product-total">Total</th>
									<th class="product-delete">Action</th>
								</tr>
							</thead>
							<tbody>
								@php $total = 0; @endphp
								@foreach($dataCart as $key => $value)
								@php $total+= $value->harga * $value->qty; @endphp
								<tr>
									<td class="product-img"><a href="{{ URL::to('produk-detail/'.$value->produk_id) }}"><img width="80" height="107" class="img-responsive" src="{{ asset('upload/produk/'.$value->gambar) }}" alt=""/></a></td>
									<td class="product-name">
										<a href="{{ URL::to('produk-detail/'.$value->produk_id) }}">{{ $value->nama_produk }}</a> 
									</td>
									<td class="product-quantity">
										<input type="hidden" name="cart_id[]" value="{{ $value->id }}">
										<input value="{{ $value->qty }}" type="number" name="qty[]" style="border: solid 1px;border-radius: 5px;">
									</td>
									<td class="product-price"><span class="amount">Rp {{ number_format($value->harga, 0, ',', '.') }}</span></td>
									<td class="product-total">Rp {{ number_format($value->harga * $value->qty, 0, ',', '.') }}</td>
									<td class="product-delete"><a href="{{ URL::to('delete-cart/'.$value->id) }}">×</a></td>
								</tr>	
								@endforeach					
							</tbody>
							<tfoot>
								<tr>
									<td class="product-name" colspan="4"><b>TOTAL</b></td>
									<td colspan="2" class="product-total" >Rp {{ number_format($total, 0, ',', '.') }}</td>
								</tr>
							</tfoot>
						</table>
					</div>											
					<div class="update-cart">
						<div class="col-md-6 col-sm-6 no-padding">
							<div class="update-cart-left">
								
							</div>				
						</div>					
						<div class="col-md-6 col-sm-6 no-padding">
							<div class="update-cart-right">
								<ul>
									<li style="display: inline-block; margin-right: 10px;"><button type="submit" class="btn btn-dark" style="padding: 14px 30px; font-weight: bold; text-transform: capitalize; border: none;">Update Cart</button></li>
									<li style="display: inline-block;"><a href="{{ URL::to('checkout') }}" class="btn btn-primary" style="padding: 14px 30px; font-weight: bold; text-transform: capitalize; color: #fff;">Lanjut Checkout <i class="fa fa-arrow-right"></i></a></li>
								</ul>
							</div>				
						</div>				
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Cart Page Section End -->	

@endsection