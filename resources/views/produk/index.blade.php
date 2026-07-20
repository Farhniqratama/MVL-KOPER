@extends('layouts.default')
@section('title', __( 'Produk' ))
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
                        <h4 class="nk-block-title" style="font-weight: bold;">Data Produk
                            <span><a href="{{ URL::to('/add-produk') }}" class="btn btn-primary" style="float: right;">Tambah Data <i class="menu-icon tf-icons bx bx-plus" style="margin-left: 5px;"></i></a></span>
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
                                    <th></th>
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
                                        <td>
                                            <div class="drodown">
                                                <a class="dropdown-toggle" href="#" type="button" data-bs-toggle="dropdown">More</a>
                                                <div class="dropdown-menu dropdown-menu-end" style="">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li class="dropdown-item">
                                                            <a href="{{ URL::to('gambar-produk/'.$value->id) }}"><i class='bx bx-bullseye me-2'></i><span>Images</span></a>
                                                        </li>
                                                        <li class="dropdown-item">
                                                            <a href="{{ URL::to('edit-produk/'.$value->id) }}"><i class='bx bx-edit me-2'></i><span>Edit</span></a>
                                                        </li>
                                                        <li class="dropdown-item">
                                                            <a href="#modalDelete_{{ $value->id }}" data-bs-toggle="modal"><i class='bx bx-trash me-2'></i><span>Delete</span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
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
@foreach($data AS $keys => $values)
    @include('produk.modal.delete')
@endforeach

@endsection


