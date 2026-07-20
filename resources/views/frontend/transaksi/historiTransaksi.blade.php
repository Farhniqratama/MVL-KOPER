@extends('frontend.layouts.default')
@section('title', __( 'Histori Transaksi' ))
@section('content')
<style>
    /* Styling for transaction action links to make them look like proper buttons */
    a[href*="bayar"] {
        padding: 8px 15px !important;
        border-radius: 5px !important;
        color: #fff !important;
        background-color: #333 !important; /* Dark */
        border: none !important;
        margin-bottom: 5px !important;
        display: inline-block !important;
        font-weight: bold !important;
    }
    
    a[href*="batalkan-pesanan"] {
        padding: 8px 15px !important;
        border-radius: 5px !important;
        color: #fff !important;
        background-color: #d9534f !important; /* Danger Red */
        border: none !important;
        margin-bottom: 5px !important;
        display: inline-block !important;
        font-weight: bold !important;
    }

    a[href*="terima-pesanan"] {
        padding: 8px 15px !important;
        border-radius: 5px !important;
        color: #fff !important;
        background-color: #5cb85c !important; /* Success Green */
        border: none !important;
        margin-bottom: 5px !important;
        display: inline-block !important;
        font-weight: bold !important;
    }

    a[href*="retur-pesanan"] {
        padding: 8px 15px !important;
        border-radius: 5px !important;
        color: #fff !important;
        background-color: #f0ad4e !important; /* Warning Yellow */
        border: none !important;
        margin-bottom: 5px !important;
        display: inline-block !important;
        font-weight: bold !important;
    }

    a[href*="ulas-produk"] {
        padding: 8px 15px !important;
        border-radius: 5px !important;
        color: #fff !important;
        background-color: #5bc0de !important; /* Info Blue */
        border: none !important;
        margin-bottom: 5px !important;
        display: inline-block !important;
        font-weight: bold !important;
    }
    
    /* Hover effects for a better UX */
    a[href*="bayar"]:hover, a[href*="batalkan-pesanan"]:hover, a[href*="terima-pesanan"]:hover, a[href*="retur-pesanan"]:hover, a[href*="ulas-produk"]:hover {
        opacity: 0.8;
        color: #fff !important;
        text-decoration: none;
    }
</style>
<div class="container-fluid mt-5 mb-10">
    @php
        $hasData0 = false;
        $hasData1 = false;
        $hasData3 = false;
        $hasData4 = false;
        $hasData5 = false;
        foreach($data as $value) {
            if ($value->status == 0) $hasData0 = true;
            if ($value->status == 1 || $value->status == 2 || $value->status == 8) $hasData1 = true;
            if ($value->status == 3) $hasData3 = true;
            if ($value->status == 4) $hasData4 = true;
            if ($value->status == 5 || $value->status == 7) $hasData5 = true;
        }
        $hasDataRetur = count($retur) > 0;
    @endphp
    <div class="row">
        <div class="col-lg-12">
            <div class="cart-table-container">
                <h4>Daftar Transaksi</h4>
                <div class="product-single-tabs">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="product-tab-desc" data-toggle="tab"
                                href="#product-desc-content" role="tab" aria-controls="product-desc-content"
                                aria-selected="true">Menunggu Pembayaran</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="product-tab-size" data-toggle="tab" href="#product-size-content"
                                role="tab" aria-controls="product-size-content" aria-selected="true">On Proses</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="product-tab-tags" data-toggle="tab" href="#product-tags-content"
                                role="tab" aria-controls="product-tags-content" aria-selected="false">Dikirim </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="product-tab-reviews" data-toggle="tab"
                                href="#product-reviews-content" role="tab" aria-controls="product-reviews-content"
                                aria-selected="false">Selesai</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="product-tab-dibatalkan" data-toggle="tab"
                                href="#product-dibatalkan-content" role="tab" aria-controls="product-dibatalkan-content"
                                aria-selected="false">Dibatalkan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="product-tab-retur" data-toggle="tab" href="#product-retur-content"
                                role="tab" aria-controls="product-retur-content" aria-selected="false">Retur</a>
                        </li>
                    </ul>

                    <!-- Menunggu Pembayaran -->
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel"
                            aria-labelledby="product-tab-desc">
                            <div class="product-desc-content">
                                @if($hasData0)
                                <table class="table table-cart table-responsive">
                                    <thead>
                                        <tr>
                                            <th class="cart_delete no">No</th>
                                            <th class="cart_product no_transaksi">No Transaksi</th>
                                            <th class="cart_product produk">Produk</th>
                                            <th class="cart_description item">Deskripsi</th>
                                            <th class="cart_unit harga">Harga</th>
                                            <th class="cart_quantity item">Qty</th>
                                            <th class="cart_total item">Total</th>
                                            <th class="cart_total metode_pembayaran">Metode Pembayaran</th>
                                            <th class="cart_total tgl_pemesanan">Tanggal Pemesanan</th>
                                            <th class="cart_total hari">Hari</th>
                                            <th class="cart_total status">Status</th>
                                            <th class="cart_total item"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $key => $value)
                                        @if($value->status == 0)
                                        <tr>
                                            <td class="cart_delete">{{ $loop->iteration }}</td>
                                            <td class="cart_delete">{{ $value->kode_transaksi }}</td>
                                            <td class="cart_product">
                                                @foreach($value->detailTransaksi as $val)
                                                <a href="{{ URL::to('produk-detail/'.$val->produk_id) }}">
                                                    <img width="80" height="107" alt="" class="img-responsive"
                                                        src="{{ asset('upload/produk/'.$val->gambar) }}">
                                                </a><br><br>
                                                @endforeach
                                            </td>
                                            <td class="cart_description">
                                                @foreach($value->detailTransaksi as $keys => $val1)
                                                <span>{{ $val1->nama_produk }}</span><br>
                                                <span>Botol: {{ $val1->tipe_botol.' '.$val1->ukuran }} ml</span>
                                                <br><br>
                                                @endforeach
                                            </td>
                                            <td class="cart_unit">
                                                @foreach($value->detailTransaksi as $val2)
                                                <span class="amount">Rp {{ number_format($val2->harga, 0, ',', '.') }}</span><br><br>
                                                @endforeach
                                            </td>
                                            <td class="cart_quantity">
                                                @foreach($value->detailTransaksi as $val3)
                                                <span class="amount">{{ number_format($val3->qty, 0, ',', '.') }}</span><br><br>
                                                @endforeach
                                            </td>
                                            <td class="cart_total">
                                                <span class="amount">Rp {{ number_format($value->total_pembayaran, 0, ',', '.')
                                                    }}</span>
                                            </td>
                                            <td>
                                                @if($value->metode_pembayaran == 1)
                                                Transfer<br>
                                                <span style="font-size:10px;color:red;">(Maksimal Pembayaran 1 Hari
                                                    setelah Checkout)</span>
                                                @elseif ($value->metode_pembayaran == 2)
                                                Qris
                                                @else
                                                COD
                                                @endif
                                            </td>
                                            <td>{{ tgl_indo($value->tgl_transaksi) }}</td>
                                            <td>{{ hari($value->tgl_transaksi) }}</td>
                                            <td>
                                                @if($value->status == 0)
                                                Menunggu Pembayaran
                                                @elseif($value->status == 1)
                                                Menunggu Konfirmasi
                                                @elseif($value->status == 2)
                                                Packing
                                                @elseif($value->status == 3)
                                                Dikirim
                                                @elseif($value->status == 4)
                                                Selesai
                                                @else
                                                Dibatalkan
                                                @endif
                                            </td>
                                            <td>
                                                @if($value->status == 0)
                                                @if ($value->metode_pembayaran == 1)
                                                <a href="{{ URL::to('bayar/'.$value->id) }}"
                                                    class="btn btn-primary btn-sm">Bayar</a>
                                                @elseif ($value->metode_pembayaran == 2)
                                                <a href="{{ URL::to('bayar-qr/'.$value->id) }}"
                                                    class="btn btn-primary btn-sm">Bayar</a>
                                                @else
                                                @endif
                                                @elseif($value->status == 3)
                                                <a href="{{ URL::to('terima-pesanan/'.$value->id) }}"
                                                    class="btn btn-primary btn-sm">Diterima</a>
                                                @else
                                                @endif
                                                @if ($value->status <= 3) <a
                                                    href="{{ URL::to('batalkan-pesanan/'.$value->id) }}"
                                                    class="btn btn-primary btn-sm">Batalkan Pesanan</a>
                                                    @endif
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <div class="text-center" style="padding: 40px 0;">
                                    <i class="fa fa-box-open" style="font-size: 40px; color: #ccc; margin-bottom: 15px;"></i><br>
                                    <h5 style="color: #666; margin: 0;">Belum ada barang</h5>
                                </div>
                                @endif
                            </div>
                            <!-- End .product-desc-content -->
                        </div>
                        <!-- End .tab-pane -->

                        <!-- On Proses -->
                        <div class="tab-pane fade" id="product-size-content" role="tabpanel"
                            aria-labelledby="product-tab-size">
                            <div class="product-size-content">
                                @if($hasData1)
                                <table class="table table-cart table-responsive">
                                    <thead>
                                        <tr>
                                            <th class="cart_delete no">No</th>
                                            <th class="cart_product no_transaksi">No Transaksi</th>
                                            <th class="cart_product produk">Produk</th>
                                            <th class="cart_description item">Deskripsi</th>
                                            <th class="cart_unit harga">Harga</th>
                                            <th class="cart_quantity item">Qty</th>
                                            <th class="cart_total item">Total</th>
                                            <th class="cart_total metode_pembayaran">Metode Pembayaran</th>
                                            <th class="cart_total tgl_pemesanan">Tanggal Pemesanan</th>
                                            <th class="cart_total hari">Hari</th>
                                            <th class="cart_total status">Status</th>
                                            <th class="cart_total item"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $key => $value)
                                        @if($value->status == 1 or $value->status == 2 or $value->status == 8)
                                        <tr>
                                            <td class="cart_delete">{{ $loop->iteration }}</td>
                                            <td class="cart_delete">{{ $value->kode_transaksi }}</td>
                                            <td class="cart_product">
                                                @foreach($value->detailTransaksi as $val)
                                                <a href="{{ URL::to('produk-detail/'.$val->produk_id) }}">
                                                    <img width="80" height="107" alt="" class="img-responsive"
                                                        src="{{ asset('upload/produk/'.$val->gambar) }}">
                                                </a><br><br>
                                                @endforeach
                                            </td>
                                            <td class="cart_description">
                                                @foreach($value->detailTransaksi as $keys => $val1)
                                                <span>{{ $val1->nama_produk }}</span><br>
                                                <span>Botol: {{ $val1->tipe_botol.' '.$val1->ukuran }} ml</span>
                                                <br><br>
                                                @endforeach
                                            </td>
                                            <td class="cart_unit">
                                                @foreach($value->detailTransaksi as $val2)
                                                <span class="amount">Rp {{ number_format($val2->harga, 0, ',', '.') }}</span><br><br>
                                                @endforeach
                                            </td>
                                            <td class="cart_quantity">
                                                @foreach($value->detailTransaksi as $val3)
                                                <span class="amount">{{ number_format($val3->qty, 0, ',', '.') }}</span><br><br>
                                                @endforeach
                                            </td>
                                            <td class="cart_total">
                                                <span class="amount">Rp {{ number_format($value->total_pembayaran, 0, ',', '.')
                                                    }}</span>
                                            </td>
                                            <td>
                                                @if($value->metode_pembayaran == 1)
                                                Transfer<br>
                                                <span style="font-size:10px;color:red;">(Maksimal Pembayaran 1 Hari
                                                    setelah Checkout)</span>
                                                @elseif ($value->metode_pembayaran == 2)
                                                Qris
                                                @else
                                                COD
                                                @endif
                                            </td>
                                            <td>{{ tgl_indo($value->tgl_transaksi) }}</td>
                                            <td>{{ hari($value->tgl_transaksi) }}</td>
                                            <td>
                                                @if($value->status == 0)
                                                Menunggu Pembayaran
                                                @elseif($value->status == 1)
                                                Menunggu Konfirmasi
                                                @elseif($value->status == 2)
                                                Packing
                                                @elseif($value->status == 3)
                                                Dikirim
                                                @elseif($value->status == 4)
                                                Selesai
                                                @elseif($value->status == 5)
                                                Dibatalkan
                                                @elseif($value->status == 7)
                                                Pembatalan Diterima
                                                @elseif($value->status == 8)
                                                Pembatalan Ditolak
                                                @else
                                                @if($value->status_retur == 0)
                                                Retur
                                                @elseif($value->status_retur == 1)
                                                Retur Dikonfirmasi
                                                @elseif($value->status_retur == 2)
                                                Retur berhasil
                                                @else
                                                Retur Ditolak
                                                @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if($value->status == 0)
                                                @if ($value->metode_pembayaran == 1)
                                                <a href="{{ URL::to('bayar/'.$value->id) }}"
                                                    class="btn btn-primary btn-sm">Bayar</a>
                                                @elseif ($value->metode_pembayaran == 2)
                                                <a href="{{ URL::to('bayar-qr/'.$value->id) }}"
                                                    class="btn btn-primary btn-sm">Bayar</a>
                                                @else
                                                @endif
                                                @elseif($value->status == 3)
                                                <a href="{{ URL::to('terima-pesanan/'.$value->id) }}"
                                                    class="btn btn-primary btn-sm">Diterima</a>
                                                @else
                                                @endif
                                                @if ($value->status <= 3) <a
                                                    href="{{ URL::to('batalkan-pesanan/'.$value->id) }}"
                                                    class="btn btn-primary btn-sm">Batalkan Pesanan</a>
                                                    @endif
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <div class="text-center" style="padding: 40px 0;">
                                    <i class="fa fa-box-open" style="font-size: 40px; color: #ccc; margin-bottom: 15px;"></i><br>
                                    <h5 style="color: #666; margin: 0;">Belum ada barang</h5>
                                </div>
                                @endif
                            </div>
                            <!-- End .product-size-content -->
                        </div>
                        <!-- End .tab-pane -->

                        <!-- Dikirim -->
                        <div class="tab-pane fade" id="product-tags-content" role="tabpanel"
                            aria-labelledby="product-tab-tags">
                            @if($hasData3)
                            <table class="table table-cart table-responsive">
                                <thead>
                                    <tr>
                                        <th class="cart_delete no">No</th>
                                        <th class="cart_product no_transaksi">No Transaksi</th>
                                        <th class="cart_product produk">Produk</th>
                                        <th class="cart_description item">Deskripsi</th>
                                        <th class="cart_unit harga">Harga</th>
                                        <th class="cart_quantity item">Qty</th>
                                        <th class="cart_total item">Total</th>
                                        <th class="cart_total metode_pembayaran">Metode Pembayaran</th>
                                        <th class="cart_total tgl_pemesanan">Tanggal Pemesanan</th>
                                        <th class="cart_total hari">Hari</th>
                                        <th class="cart_total status">Status</th>
                                        <th class="cart_total item"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $key => $value)
                                    @if($value->status == 3)
                                    <tr>
                                        <td class="cart_delete">{{ $loop->iteration }}</td>
                                        <td class="cart_delete">{{ $value->kode_transaksi }}</td>
                                        <td class="cart_product">
                                            @foreach($value->detailTransaksi as $val)
                                            <a href="{{ URL::to('produk-detail/'.$val->produk_id) }}">
                                                <img width="80" height="107" alt="" class="img-responsive"
                                                    src="{{ asset('upload/produk/'.$val->gambar) }}">
                                            </a><br><br>
                                            @endforeach
                                        </td>
                                        <td class="cart_description">
                                            @foreach($value->detailTransaksi as $keys => $val1)
                                            <span>{{ $val1->nama_produk }}</span><br>
                                            <span>Botol: {{ $val1->tipe_botol.' '.$val1->ukuran }} ml</span>
                                            <br><br>
                                            @endforeach
                                        </td>
                                        <td class="cart_unit">
                                            @foreach($value->detailTransaksi as $val2)
                                            <span class="amount">Rp {{ number_format($val2->harga, 0, ',', '.') }}</span><br><br>
                                            @endforeach
                                        </td>
                                        <td class="cart_quantity">
                                            @foreach($value->detailTransaksi as $val3)
                                            <span class="amount">{{ number_format($val3->qty, 0, ',', '.') }}</span><br><br>
                                            @endforeach
                                        </td>
                                        <td class="cart_total">
                                            <span class="amount">Rp {{ number_format($value->total_pembayaran, 0, ',', '.') }}</span>
                                        </td>
                                        <td>
                                            @if($value->metode_pembayaran == 1)
                                            Transfer<br>
                                            <span style="font-size:10px;color:red;">(Maksimal Pembayaran 1 Hari setelah
                                                Checkout)</span>
                                            @elseif ($value->metode_pembayaran == 2)
                                            Qris
                                            @else
                                            COD
                                            @endif
                                        </td>
                                        <td>{{ tgl_indo($value->tgl_transaksi) }}</td>
                                        <td>{{ hari($value->tgl_transaksi) }}</td>
                                        <td>
                                            @if($value->status == 0)
                                            Menunggu Pembayaran
                                            @elseif($value->status == 1)
                                            Menunggu Konfirmasi
                                            @elseif($value->status == 2)
                                            Packing
                                            @elseif($value->status == 3)
                                            Dikirim
                                            @elseif($value->status == 4)
                                            Selesai
                                            @else
                                            Dibatalkan
                                            @endif
                                        </td>
                                        <td>
                                            @if($value->status == 0)
                                            @if ($value->metode_pembayaran == 1)
                                            <a href="{{ URL::to('bayar/'.$value->id) }}"
                                                class="btn btn-primary btn-sm">Bayar</a>
                                            @elseif ($value->metode_pembayaran == 2)
                                            <a href="{{ URL::to('bayar-qr/'.$value->id) }}"
                                                class="btn btn-primary btn-sm">Bayar</a>
                                            @else
                                            @endif
                                            @elseif($value->status == 3)
                                            <a href="{{ URL::to('terima-pesanan/'.$value->id) }}"
                                                class="btn btn-primary btn-sm">Diterima</a>
                                            @else
                                            @endif
                                            @if ($value->status <= 3) <a
                                                href="{{ URL::to('batalkan-pesanan/'.$value->id) }}"
                                                class="btn btn-primary btn-sm">Batalkan Pesanan</a>
                                                @endif
                                                <a href="{{ URL::to('retur-pesanan/'.$value->id) }}"
                                                    class="btn btn-primary btn-sm">Retur Produk</a>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <div class="text-center" style="padding: 40px 0;">
                                <i class="fa fa-box-open" style="font-size: 40px; color: #ccc; margin-bottom: 15px;"></i><br>
                                <h5 style="color: #666; margin: 0;">Belum ada barang</h5>
                            </div>
                            @endif
                        </div>
                        <!-- End .tab-pane -->


                        <!-- Selesai -->
                        <div class="tab-pane fade" id="product-reviews-content" role="tabpanel"
                            aria-labelledby="product-tab-reviews">
                            <div class="product-reviews-content">
                                @if($hasData4)
                                <table class="table table-cart table-responsive">
                                    <thead>
                                        <tr>
                                            <th class="cart_delete no">No</th>
                                            <th class="cart_product no_transaksi">No Transaksi</th>
                                            <th class="cart_product produk">Produk</th>
                                            <th class="cart_description item">Deskripsi</th>
                                            <th class="cart_unit harga">Harga</th>
                                            <th class="cart_quantity item">Qty</th>
                                            <th class="cart_total item">Total</th>
                                            <th class="cart_total metode_pembayaran">Metode Pembayaran</th>
                                            <th class="cart_total tgl_pemesanan">Tanggal Pemesanan</th>
                                            <th class="cart_total hari">Hari</th>
                                            <th class="cart_total status">Status</th>
                                            <th class="cart_total item"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $key => $value)
                                        @if($value->status == 4)
                                        <tr>
                                            <td class="cart_delete">{{ $loop->iteration }}</td>
                                            <td class="cart_delete">{{ $value->kode_transaksi }}</td>
                                            <td class="cart_product">
                                                @foreach($value->detailTransaksi as $val)
                                                <a href="{{ URL::to('produk-detail/'.$val->produk_id) }}">
                                                    <img width="80" height="107" alt="" class="img-responsive"
                                                        src="{{ asset('upload/produk/'.$val->gambar) }}">
                                                </a><br><br>
                                                @endforeach
                                            </td>
                                            <td class="cart_description">
                                                @foreach($value->detailTransaksi as $keys => $val1)
                                                <span>{{ $val1->nama_produk }}</span><br>
                                                <span>Botol: {{ $val1->tipe_botol.' '.$val1->ukuran }} ml</span>
                                                <br><br>
                                                @endforeach
                                            </td>
                                            <td class="cart_unit">
                                                @foreach($value->detailTransaksi as $val2)
                                                <span class="amount">Rp {{ number_format($val2->harga, 0, ',', '.') }}</span><br><br>
                                                @endforeach
                                            </td>
                                            <td class="cart_quantity">
                                                @foreach($value->detailTransaksi as $val3)
                                                <span class="amount">{{ number_format($val3->qty, 0, ',', '.') }}</span><br><br>
                                                @endforeach
                                            </td>
                                            <td class="cart_total">
                                                <span class="amount">Rp {{ number_format($value->total_pembayaran, 0, ',', '.')
                                                    }}</span>
                                            </td>
                                            <td>
                                                @if($value->metode_pembayaran == 1)
                                                Transfer<br>
                                                <span style="font-size:10px;color:red;">(Maksimal Pembayaran 1 Hari
                                                    setelah Checkout)</span>
                                                @elseif ($value->metode_pembayaran == 2)
                                                Qris
                                                @else
                                                COD
                                                @endif
                                            </td>
                                            <td>{{ tgl_indo($value->tgl_transaksi) }}</td>
                                            <td>{{ hari($value->tgl_transaksi) }}</td>
                                            <td>
                                                @if($value->status == 0)
                                                Menunggu Pembayaran
                                                @elseif($value->status == 1)
                                                Menunggu Konfirmasi
                                                @elseif($value->status == 2)
                                                Packing
                                                @elseif($value->status == 3)
                                                Dikirim
                                                @elseif($value->status == 4)
                                                Selesai
                                                @else
                                                Dibatalkan
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ URL::to('ulas-produk/'.$value->id) }}"
                                                    class="btn btn-primary btn-sm">Ulas Produk</a>
                                                <a href="{{ URL::to('retur-pesanan/'.$value->id) }}"
                                                    class="btn btn-primary btn-sm">Retur Produk</a>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <div class="text-center" style="padding: 40px 0;">
                                    <i class="fa fa-box-open" style="font-size: 40px; color: #ccc; margin-bottom: 15px;"></i><br>
                                    <h5 style="color: #666; margin: 0;">Belum ada barang</h5>
                                </div>
                                @endif
                            </div>
                            <!-- End .product-reviews-content -->
                        </div>

                        <!-- Dibatalkan -->
                        <div class="tab-pane fade" id="product-dibatalkan-content" role="tabpanel"
                            aria-labelledby="product-tab-dibatalkan">
                            <div class="product-dibatalkan-content">
                                @if($hasData5)
                                <table class="table table-cart table-responsive">
                                    <thead>
                                        <tr>
                                            <th class="cart_delete no">No</th>
                                            <th class="cart_product no_transaksi">No Transaksi</th>
                                            <th class="cart_product produk">Produk</th>
                                            <th class="cart_description item">Deskripsi</th>
                                            <th class="cart_unit harga">Harga</th>
                                            <th class="cart_quantity item">Qty</th>
                                            <th class="cart_total item">Total</th>
                                            <th class="cart_total metode_pembayaran">Metode Pembayaran</th>
                                            <th class="cart_total tgl_pemesanan">Tanggal Pemesanan</th>
                                            <th class="cart_total hari">Hari</th>
                                            <th class="cart_total status">Status</th>
                                            <th class="cart_total item"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $key => $value)
                                        @if($value->status == 5 || $value->status == 7)
                                        <!-- Fixed condition -->
                                        <tr>
                                            <td class="cart_delete">{{ $loop->iteration }}</td>
                                            <td class="cart_delete">{{ $value->kode_transaksi }}</td>
                                            <td class="cart_product">
                                                @foreach($value->detailTransaksi as $val)
                                                <a href="{{ URL::to('produk-detail/'.$val->produk_id) }}">
                                                    <img width="80" height="107" alt="" class="img-responsive"
                                                        src="{{ asset('upload/produk/'.$val->gambar) }}">
                                                </a><br><br>
                                                @endforeach
                                            </td>
                                            <td class="cart_description">
                                                @foreach($value->detailTransaksi as $keys => $val1)
                                                <span>{{ $val1->nama_produk }}</span><br>
                                                <span>Botol: {{ $val1->tipe_botol.' '.$val1->ukuran }} ml</span>
                                                <br><br>
                                                @endforeach
                                            </td>
                                            <td class="cart_unit">
                                                @foreach($value->detailTransaksi as $val2)
                                                <span class="amount">Rp {{ number_format($val2->harga, 0, ',', '.') }}</span><br><br>
                                                @endforeach
                                            </td>
                                            <td class="cart_quantity">
                                                @foreach($value->detailTransaksi as $val3)
                                                <span class="amount">{{ number_format($val3->qty, 0, ',', '.') }}</span><br><br>
                                                @endforeach
                                            </td>
                                            <td class="cart_total">
                                                <span class="amount">Rp {{ number_format($value->total_pembayaran, 0, ',', '.')
                                                    }}</span>
                                            </td>
                                            <td>
                                                @if($value->metode_pembayaran == 1)
                                                Transfer<br>
                                                <span style="font-size:10px;color:red;">(Maksimal Pembayaran 1 Hari
                                                    setelah Checkout)</span>
                                                @elseif ($value->metode_pembayaran == 2)
                                                Qris
                                                @else
                                                COD
                                                @endif
                                            </td>
                                            <td>{{ tgl_indo($value->tgl_transaksi) }}</td>
                                            <td>{{ hari($value->tgl_transaksi) }}</td>
                                            <td>
                                                @if($value->status == 0)
                                                Menunggu Pembayaran
                                                @elseif($value->status == 1)
                                                Menunggu Konfirmasi
                                                @elseif($value->status == 2)
                                                Packing
                                                @elseif($value->status == 3)
                                                Dikirim
                                                @elseif($value->status == 4)
                                                Selesai
                                                @else
                                                Dibatalkan
                                                @endif
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <div class="text-center" style="padding: 40px 0;">
                                    <i class="fa fa-box-open" style="font-size: 40px; color: #ccc; margin-bottom: 15px;"></i><br>
                                    <h5 style="color: #666; margin: 0;">Belum ada barang</h5>
                                </div>
                                @endif
                            </div>
                            <!-- End .product-reviews-content -->
                        </div>

                        <!-- Retur -->
                        <div class="tab-pane fade" id="product-retur-content" role="tabpanel"
                            aria-labelledby="product-tab-retur">
                            <div class="product-retur-content">
                                @if($hasDataRetur)
                                <table class="table table-cart table-responsive">
                                    <thead>
                                        <tr>
                                            <th class="cart_delete no">No</th>
                                            <th class="cart_product no_transaksi">No Transaksi</th>
                                            <th class="cart_product produk">Produk</th>
                                            <th class="cart_description item">Deskripsi</th>
                                            <th class="cart_unit harga">Harga</th>
                                            <th class="cart_quantity item">Qty</th>
                                            <th class="cart_total item">Total</th>
                                            <th class="cart_total metode_pembayaran">Metode Pembayaran</th>
                                            <th class="cart_total tgl_pemesanan">Tanggal Pemesanan</th>
                                            <th class="cart_total hari">Hari</th>
                                            <th class="cart_total status">Status</th>
                                            <th class="cart_total item"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($retur as $key => $value)
                                        <tr>
                                            <td class="cart_delete">{{ $loop->iteration }}</td>
                                            <td class="cart_delete">{{ $value->kode_transaksi }}</td>
                                            <td class="cart_product">
                                                @foreach($value->detailTransaksi as $val)
                                                <a href="{{ URL::to('produk-detail/'.$val->produk_id) }}">
                                                    <img width="80" height="107" alt="" class="img-responsive"
                                                        src="{{ asset('upload/produk/'.$val->gambar) }}">
                                                </a><br><br>
                                                @endforeach
                                            </td>
                                            <td class="cart_description">
                                                @foreach($value->detailTransaksi as $keys => $val1)
                                                <span>{{ $val1->nama_produk }}</span><br>
                                                <span>Botol: {{ $val1->tipe_botol.' '.$val1->ukuran }} ml</span>
                                                <br><br>
                                                @endforeach
                                            </td>
                                            <td class="cart_unit">
                                                @foreach($value->detailTransaksi as $val2)
                                                <span class="amount">Rp {{ number_format($val2->harga, 0, ',', '.') }}</span><br><br>
                                                @endforeach
                                            </td>
                                            <td class="cart_quantity">
                                                @foreach($value->detailTransaksi as $val3)
                                                <span class="amount">{{ number_format($val3->qty, 0, ',', '.') }}</span><br><br>
                                                @endforeach
                                            </td>
                                            <td class="cart_total">
                                                <span class="amount">Rp {{ number_format($value->total_pembayaran, 0, ',', '.')
                                                    }}</span>
                                            </td>
                                            <td>
                                                @if($value->metode_pembayaran == 1)
                                                Transfer<br>
                                                <span style="font-size:10px;color:red;">(Maksimal Pembayaran 1 Hari
                                                    setelah Checkout)</span>
                                                @elseif ($value->metode_pembayaran == 2)
                                                Qris
                                                @else
                                                COD
                                                @endif
                                            </td>
                                            <td>{{ tgl_indo($value->tgl_transaksi) }}</td>
                                            <td>{{ hari($value->tgl_transaksi) }}</td>
                                            <td>
                                                @if($value->status_retur == 0)
                                                Menunggu Konfirmasi
                                                @elseif($value->status == 1)
                                                Dikonfirmasi
                                                @else
                                                Retur Berhasil
                                                @endif
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <div class="text-center" style="padding: 40px 0;">
                                    <i class="fa fa-box-open" style="font-size: 40px; color: #ccc; margin-bottom: 15px;"></i><br>
                                    <h5 style="color: #666; margin: 0;">Belum ada barang</h5>
                                </div>
                                @endif
                            </div>
                            <!-- End .product-reviews-content -->
                        </div>
                        <!-- End .tab-pane -->
                    </div>
                    <!-- End .tab-content -->
                </div>
            </div><!-- End .cart-table-container -->
        </div><!-- End .col-lg-8 -->
        {{-- <div class="col-lg-4">
            <div class="sidebar-wrapper">
                <div class="widget widget-featured">
                    <h3 class="widget-title">PRODUK LAINYA</h3>

                    <div class="widget-body">
                        <div class="owl-carousel widget-featured-products">
                            <div class="featured-col">
                                @foreach ($produk as $key => $valProduk)
                                @if($key <= 2) <div class="product-default left-details product-widget">
                                    <figure>
                                        <a href="{{ URl::to('produk-detail/'.$valProduk->id) }}">
                                            <img src="{{ asset('upload/produk/'.$valProduk->gambar) }}" width="75"
                                                height="75" alt="product-widget" />
                                        </a>
                                    </figure>
                                    <div class="product-details">
                                        <h3 class="product-title"> <a
                                                href="{{ URl::to('produk-detail/'.$valProduk->id) }}">{{
                                                $valProduk->nama_produk }}</a> </h3>
                                        <div class="ratings-container">
                                            <!-- End .product-ratings -->
                                        </div>
                                        <!-- End .product-container -->
                                        <div class="price-box">
                                            <span class="product-price">Rp {{ number_format($valProduk->harga, 0, ',', '.') }}
                                                (ml)</span>
                                        </div>
                                        <!-- End .price-box -->
                                    </div>
                                    <!-- End .product-details -->
                            </div>
                            @endif
                            @endforeach
                        </div>
                        <!-- End .featured-col -->

                        <div class="featured-col">
                            @foreach ($produk as $key => $valueProduk)
                            @if($key > 2)
                            <div class="product-default left-details product-widget">
                                <figure>
                                    <a href="{{ URl::to('produk-detail/'.$valueProduk->id) }}">
                                        <img src="{{ asset('upload/produk/'.$valueProduk->gambar) }}" width="75"
                                            height="75" alt="product-widget" />
                                    </a>
                                </figure>

                                <div class="product-details">
                                    <h3 class="product-title"> <a
                                            href="{{ URl::to('produk-detail/'.$valProduk->id) }}">{{
                                            $valueProduk->nama_produk }}</a> </h3>
                                    <div class="ratings-container">
                                        <!-- End .product-ratings -->
                                    </div>
                                    <!-- End .product-container -->
                                    <div class="price-box">
                                        <span class="product-price">Rp {{ number_format($valueProduk->harga, 0, ',', '.') }}
                                            (ml)</span>
                                    </div>
                                    <!-- End .price-box -->
                                </div>
                                <!-- End .product-details -->
                            </div>
                            @endif
                            @endforeach
                        </div>
                        <!-- End .featured-col -->
                    </div>
                    <!-- End .widget-featured-slider -->
                </div>
                <!-- End .widget-body -->
            </div>
        </div>
    </div> --}}
</div><!-- End .row -->
</div>
@endsection