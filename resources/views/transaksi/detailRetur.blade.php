
@extends('layouts.default')
@section('title', __( 'Detail Pesanan' ))
@section('content')

<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="components-preview wide-md mx-auto">
            <div class="nk-block nk-block-lg">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">

                        @include('layouts.partials.notification')
                    </div>
                </div>
                <div class="card card-bordered card-preview" style="padding:30px;">
                    <h4 class="nk-block-title" style="font-weight: bold;">Detail Pesanan
                    </h4>
                    <div class="card-inner">
                        <table class="table">
                        	<tr>
                        		<th>No Transaksi</th>
                        		<th>{{ $data->kode_transaksi }}</th>
                        	</tr>
                        	<tr>
                        		<th>Pelanggan</th>
                        		<th>{{ $data->nama_pelanggan }}</th>
                        	</tr>
                        	<tr>
                        		<th>Tanggal Transaksi</th>
                        		<th>{{ $data->tgl_transaksi }}</th>
                        	</tr>
                        	<tr>
                        		<th>Total</th>
                        		<th>Rp {{ number_format($data->total_pembayaran, 0, ',', '.') }}</th>
                        	</tr>
							@if(!empty($data->bukti_bayar))
                        	<tr>
                        		<th>Bukti Pembayaran</th>
                        		<th><a href="{{ asset('images/bukti_bayar/'.$data->bukti_tf) }}" target="_blank"><img src="{{ asset('images/bukti_bayar/'.$data->bukti_tf) }}" style="width:100px;"></a></th>
                        	</tr>
							@endif
							@if ($data->status == 5 )
							<tr>
								<th>Alasan Pembatalan</th>
								<th>{{ $data->keterangan_batal }}</th>
							</tr>
							@endif
							@if ($data->status == 6 )
							<tr>
								<th>Alasan Retur</th>
								<th>{{ $retur->keterangan }}</th>
							</tr>
							@endif
                        </table>
                        <hr>
                        <table class="table">
                        	<thead>
                        		<tr>
                        			<th>Produk</th>
                        			<th>Deskripsi</th>
                        			<th>Harga</th>
                        			<th>Qty</th>
									
                        			
                        		</tr>
                        	</thead>
                        	<tbody>
                        		@foreach($detailTransaksi as $key => $value)
                        		<tr>
                        			<td><img src="{{ asset('upload/produk/'.$value->gambar) }}" style="width:70px;"></td>
                        			<td>{{ $value->nama_produk }}</td>
                        			<td>{{ $value->harga }}</td>
                        			<td>{{ $value->qty }}</td>
                        		</tr>
                        		@endforeach
                        	</tbody>
                        </table>
                        <form method="post" action="{{ URL::to('update-transaksi-retur/'.$data->id) }}">
                        	@csrf
                        	<div class="row gy-4">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label" for="default-03">Status Pemesanan</label>
                                        <div class="form-control-wrap">
                                            <select class="form-control" name="status" id="status-select" required>
                                                <option value="0" @if($retur->status == 0) selected @endif >Menunggu Konfirmasi</option>
                                            	<option value="1" @if($retur->status == 1) selected @endif >Dikonfirmasi</option>
                                            	<option value="2" @if($retur->status == 2) selected @endif >Retur Berhasil</option>
                                            	<option value="3" @if($retur->status == 3) selected @endif >Tolak Retur</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
								<div class="col-sm-12" id="rejection-reason-group" style="display: none;">
									<div class="form-group">
										<label class="form-label" for="rejection-reason">Alasan Penolakan</label>
										<textarea class="form-control" name="alasan_penolakan" id="rejection-reason" placeholder="Tambahkan alasan penolakan...">{{ $retur->alasan_penolakan }}</textarea>
									</div>
								</div>
                                <div class="col-sm-12" style="margin-top: 25px;">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="{{ URL::to('transaksi') }}" class="btn btn-warning">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
	document.addEventListener('DOMContentLoaded', function () {
		const statusSelect = document.getElementById('status-select');
		const rejectionReasonGroup = document.getElementById('rejection-reason-group');

		// Fungsi untuk mengontrol tampilan textarea
		function toggleRejectionReason() {
			if (statusSelect.value === '3') {
				rejectionReasonGroup.style.display = 'block'; // Tampilkan textarea
			} else {
				rejectionReasonGroup.style.display = 'none'; // Sembunyikan textarea
			}
		}

		// Jalankan saat dropdown berubah
		statusSelect.addEventListener('change', toggleRejectionReason);

		// Jalankan saat halaman dimuat (untuk nilai awal)
		toggleRejectionReason();
	});
</script>
@endsection