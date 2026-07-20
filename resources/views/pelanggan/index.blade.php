@extends('layouts.default')
@section('title', __( 'Pelanggan' ))
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
                        <h4 class="nk-block-title" style="font-weight: bold;">Data Pelanggan
                            <span><a href="{{ URL::to('/add-pelanggan') }}" class="btn btn-primary" style="float: right;">Tambah Data <i class="menu-icon tf-icons bx bx-plus" style="margin-left: 5px;"></i></a></span>
                        </h4>
                        <table class="datatable-init table" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Email</th>
                                    <th>No Telp</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data AS $key => $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $value->nama }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>{{ $value->no_telp }}</td>
                                        <td>
                                            <a href="{{ URL::to('edit-pelanggan/'.$value->id) }}" class="btn btn-primary">Edit</a>
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
    @include('pelanggan.modal.delete')
@endforeach

@endsection


