@extends('layouts.default')
@section('title', __( 'Laporan Penjualan' ))
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
                <div class="card card-bordered card-preview" style="padding: 30px;">
                    <div class="card-inner">
                        <h4 class="nk-block-title" style="font-weight: bold;">Data Laporan Penjualan</h4>
                        <table class="datatable-init table" id="myTable">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">No</th>
                                    <th>No Transaksi</th>
                                    <th>Nama</th>
                                    <th>Produk</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach($data AS $key => $value)
                                @php $jml = count($value->detailTransaksi); @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $value->kode_transaksi }}</td>
                                        <td>{{ $value->nama_pelanggan }}</td>
                                        
                                        <td>
                                            @foreach($value->detailTransaksi as $index => $val1)
                                                {{ $val1->nama_produk }} 
                                                @if($index < $value->detailTransaksi->count() - 1)
                                                    , 
                                                @endif
                                                @if($index == $value->detailTransaksi->count() - 2)
                                                    dan 
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            
                                            @foreach($value->detailTransaksi as $index => $val4)
                                                @php $total += $val4->harga * $val4->qty; @endphp
                                            @endforeach
                                            Rp {{ number_format($total, 0, ',', '.') }}
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


