@extends('layouts.default')
@section('title', __( 'Laporan Produk' ))
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
                        <h4 class="nk-block-title" style="font-weight: bold;">Laporan Data Produk
                        </h4>
                        <table class="datatable-init table" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Produk</th>
                                    <th>Kategori</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data AS $key => $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $value->kd_produk }}</td>
                                        <td>{{ $value->nama_kategori }}</td>
                                        <td>{{ $value->nama_produk }}</td>
                                        <td>{{ number_format($value->harga, 0, ',', '.') }}</td>
                                        <td>{{ $value->deskripsi }}</td>
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


