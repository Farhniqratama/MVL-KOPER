@extends('layouts.default')
@section('title', __( 'Users' ))
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
                    <h4 class="nk-block-title" style="font-weight: bold;">List Users 
                        <span><a href="{{ URL::to('/add-user') }}" class="btn btn-primary" style="float: right;">Tambah Data</a></span>
                    </h4>
                    <div class="card-inner">
                        
                        
                        
                        <table class="datatable-init table" id="myTable">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data AS $key => $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>{{ $value->username }}</td>
                                        <td>{{ $value->role }}</td>
                                        <td>
                                            @if($value->id != 1)
                                            <a href="{{ URL::to('edit-user/'.$value->id) }}" class="btn btn-primary">Edit</a>
                                            <a href="#modalDelete_{{ $value->id }}" class="btn btn-danger" data-bs-toggle="modal">Delete</button>
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
@foreach($data AS $keys => $values)
    @include('user.modal.delete')
@endforeach

@endsection


