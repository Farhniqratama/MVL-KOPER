@extends('layouts.default')
@section('title', __( 'Edit Pelanggan' ))
@section('content')
<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="components-preview wide-md mx-auto">
            <div class="nk-block nk-block-lg">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h4 class="title nk-block-title">Edit Pelanggan</h4>
                        @include('layouts.partials.notification')
                    </div>
                </div>
                <div class="card card-bordered card-preview" style="padding: 30px;">
                    <div class="card-inner">
                        <div class="preview-block">
                            <form method="POST" action="{{ URL::to('/do-update-pelanggan/'.$data->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row gy-4">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="default-03">Nama Pelanggan</label>
                                            <div class="form-control-wrap">
                                                <input type="text" name="nama" class="form-control" value="{{ $data->nama }}" required placeholder="Input Nama Pelanggan">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="default-03">Email</label>
                                            <div class="form-control-wrap">
                                                <input type="email" name="email" class="form-control" value="{{ $data->email }}" required placeholder="Input Email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="default-02">No Telephone</label>
                                            <div class="form-control-wrap">
                                                <input type="number" class="form-control" name="no_telp" value="{{ $data->no_telp }}" id="default-02" required placeholder="Input No Telephone">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="default-02">Keterangan</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="keterangan" value="{{ $data->keterangan }}" id="default-02" placeholder="Input Keterangan">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label" for="default-02">Username</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="username" value="{{ $user->username }}" id="default-02" required placeholder="Input Username">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label" for="default-04">Password</label>
                                            <span style="color: red; font-size: 12px; font-weight: normal;margin-left: 20px;">*Fill in the fields below to change the password</span>
                                            <div class="form-control-wrap">
                                                <input type="password" name="password" class="form-control" id="default-04" placeholder="Input Password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12" style="margin-top: 15px;">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">
                                                Save Changes
                                            </button>
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
</div>
@endsection