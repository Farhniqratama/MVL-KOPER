@extends('layouts.default')
@section('title', __( 'Edit Produk' ))
@section('content')
<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="components-preview wide-md mx-auto">
            <div class="nk-block nk-block-lg">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h4 class="title nk-block-title">Edit Produk</h4>
                        @include('layouts.partials.notification')
                    </div>
                </div>
                <div class="card card-bordered card-preview" style="padding: 30px;">
                    <div class="card-inner">
                        <div class="preview-block">
                            <form method="POST" action="{{ URL::to('/do-update-produk/'.$data->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row gy-4">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="default-03">Kode Produk</label>
                                            <div class="form-control-wrap">
                                                <input type="text" name="kd_produk" class="form-control" value="{{ $data->kd_produk }}" required placeholder="Input Kode Produk">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="default-03">Kategori</label>
                                            <div class="form-control-wrap">
                                                <select class="form-control" name="kategori_id" required>
                                                    <option value="" selected disabled>-- Pilih Kategori --</option>
                                                    @foreach($kategori as $key => $value)
                                                    <option value="{{ $value->id }}" @if($data->kategori_id == $value->id) selected @endif>{{ $value->nama_kategori }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="default-03">Nama Produk</label>
                                            <div class="form-control-wrap">
                                                <input type="text" name="nama_produk" class="form-control" value="{{ $data->nama_produk }}" required placeholder="Input Nama Produk">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="default-03">Harga</label>
                                            <div class="form-control-wrap">
                                                <input type="number" name="harga" class="form-control" value="{{ $data->harga }}" required placeholder="Input Harga">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label" for="default-03">Deskripsi</label>
                                            <div class="form-control-wrap">
                                                <textarea class="form-control" name="deskripsi" required placeholder="Deskripsi Produk">{{ $data->deskripsi }}</textarea>
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