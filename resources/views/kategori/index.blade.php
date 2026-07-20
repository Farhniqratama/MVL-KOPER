@extends('layouts.default')
@section('title', __( 'Kategori' ))
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
                        <h4 class="nk-block-title" style="font-weight: bold;">Data Kategori
                            <span><a href="{{ URL::to('/add-kategori') }}" class="btn btn-primary" style="float: right;">Tambah Data <i class="menu-icon tf-icons bx bx-plus" style="margin-left: 5px;"></i></a></span>
                        </h4>
                        <table class="datatable-init table" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kategori</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data AS $key => $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $value->nama_kategori }}</td>
                                        <td>
                                            <a href="{{ URL::to('edit-kategori/'.$value->id) }}" class="btn btn-primary">Edit</a>
                                            <a href="#modalDelete_{{ $value->id }}" class="btn btn-danger" data-bs-toggle="modal">Delete</a>
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
    @include('kategori.modal.delete')
@endforeach

@endsection


