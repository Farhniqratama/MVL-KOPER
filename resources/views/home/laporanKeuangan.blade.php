@extends('layouts.default')
@section('title', __( 'Laporan Keuangan' ))
@section('content')
<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="components-preview wide-md mx-auto">
            <div class="nk-block nk-block-lg">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h4 class="title nk-block-title">Laporan Keuangan</h4>
                        @include('layouts.partials.notification')
                    </div>
                </div>
                <div class="card card-bordered card-preview" style="padding: 30px;">
                    <div class="card-inner">
                        <div class="preview-block">
                            <form method="GET" action="{{ URL::to('/laporan-keuangan') }}" enctype="multipart/form-data">
                               
                                <div class="row gy-4">
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label class="form-label" for="default-03">Dari Tanggal</label>
                                            <div class="form-control-wrap">
                                                <input type="date" name="start_date" class="form-control" required placeholder="Input Dari Tanggal">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label class="form-label" for="default-03">Sampai Tanggal</label>
                                            <div class="form-control-wrap">
                                            <input type="date" name="end_date" class="form-control" required placeholder="Input Dari Tanggal">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2" style="margin-top: 50px;">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><hr>
                    <div class="col-lg-6 mb-4 order-0">
                        <div class="card">
                            <div class="d-flex align-items-end row">
                                <div class="col-sm-12">
                                    <div class="card-body">
                                        <h5 class="card-title" style="font-weight: bold;">Pendapatan Bulan Ini</h5>
                                        <p class="mb-4">{{ number_format($sumTrans, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection