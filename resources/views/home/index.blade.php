<?php use App\Models\VendorBid; ?>
@extends('layouts.default')
@section('title', __( 'Home' ))
@section('content')

<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-12">
                    <div class="card-body">
                        <h5 class="card-title" style="font-weight: bold;">SELAMAT DATANG DI MVL KOPER!</h5>
                        <p class="mb-4">Proyek Toko yang akan datang pada tahun 2026.</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-12">
                    <div class="card-body">
                        <h5 class="card-title" style="font-weight: bold;">Total Customer</h5>
                        <p class="mb-4">{{ $countP }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-12">
                    <div class="card-body">
                        <h5 class="card-title" style="font-weight: bold;">Total Produk</h5>
                        <p class="mb-4">{{ $countProd }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
@endsection