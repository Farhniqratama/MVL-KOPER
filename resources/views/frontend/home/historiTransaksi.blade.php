@extends('frontend.layouts.default')
@section('title', __( 'Histori Transaksi' ))
@section('content')

<div class="pagehding-sec">
	<div class="images-overlay"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-heading">
					<h1>Histori Transaksi</h1>
				</div>
				<div class="breadcrumb-list">
					<ul>
						<li><a href="{{ URL::to('/') }}">Home</a></li>
						<li><a href="#">shop</a></li>
						<li><a href="#">Histori Transaksi</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="columns" class="columns-container cart-page-sec pt-100 pb-100">
	<!-- container -->
	<div class="container">
		<div id="order-detail-content" class="table_block table-responsive">
			<form method="post" action="{{ URL::to('update-cart') }}">
				@csrf
				<table id="cart_summary" class="table table-bordered">
					<thead>
						<tr>
							<th class="cart_delete last_item">No</th>
							<th class="cart_product first_item">No Transaksi</th>
							<th class="cart_product first_item">Produk</th>
							<th class="cart_description item">Deskripsi</th>
							<th class="cart_unit item text-right">Harga</th>
							<th class="cart_quantity item text-center">Qty</th>
							<th class="cart_total item text-right">Total</th>
							<th class="cart_total item text-right">Status</th>
							<th class="cart_total item text-right"></th>
						</tr>
					</thead>
					<tbody>
						@foreach($data as $key => $value)
						<tr>
							<td class="cart_delete text-center">{{ $loop->iteration }}</td>
							<td class="cart_delete text-center">{{ $value->kode_transaksi }}</td>
							<td class="cart_product">
								@foreach($value->detailTransaksi as $val)
								<a href="{{ URL::to('produk-detail/'.$val->produk_id) }}">
									<img width="80" height="107" alt="" class="img-responsive"
										src="{{ asset('upload/produk/'.$val->gambar) }}">
								</a><br><br>
								@endforeach
							</td>
							<td class="cart_description">
								@foreach($value->detailTransaksi as $val1)
								<a href="page-detail-wines.html">{{ $val1->nama_produk }}</a><br><br>
								@endforeach
							</td>
							<td class="cart_unit text-right">
								@foreach($value->detailTransaksi as $val2)
								<span class="amount">Rp {{ number_format($val2->harga, 0, ',', '.') }}</span><br><br>
								@endforeach
							</td>
							<td class="cart_quantity text-center">
								@foreach($value->detailTransaksi as $val3)
								<span class="amount">{{ number_format($val3->qty, 0, ',', '.') }}</span><br><br>
								@endforeach
							</td>
							<td class="cart_total text-right">
								@foreach($value->detailTransaksi as $val4)
								<span class="amount">Rp {{ number_format($val4->harga * $val4->qty, 0, ',', '.') }}</span><br><br>
								@endforeach
							</td>
							<td>
								@if($value->status == 0)
								Menunggu Pembayaran
								@elseif($value->status == 1)
								Menunggu Konfirmasi
								@elseif($value->status == 2)
								Packing
								@elseif($value->status == 3)
								Dikirim
								@else
								Selesai
								@endif
							</td>
							<td>
								@if($value->status == 0)
								<a href="{{ URL::to('bayar/'.$value->id) }}" class="btn btn-primary">Bayar</a>
								@elseif($value->status == 3)
								<a href="{{ URL::to('terima-pesanan/'.$value->id) }}"
									class="btn btn-primary">Diterima</a>
								@else @endif
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
		</div><!-- end order-detail-content -->
	</div> <!-- end container -->
</div>
<!--end columns -->

@endsection