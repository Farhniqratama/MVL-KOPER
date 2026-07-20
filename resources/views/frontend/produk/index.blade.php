@extends('frontend.layouts.default')
@section('title', __( 'Produk' ))
@section('content')

<style>
    .coming-soon-container {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        padding: 50px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .coming-soon-icon {
        font-size: 60px;
        color: #007bff;
        margin-bottom: 15px;
    }

    .coming-soon-text {
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }

    .coming-soon-subtext {
        font-size: 16px;
        color: #666;
        margin-bottom: 20px;
    }

    .coming-soon-btn {
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        border-radius: 5px;
    }
</style>

<div class="container-fluid">
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Produk</a></li>
        </ol>
    </nav>

    <div class="products-section pt-0">
        <h2 class="section-title">Produk Kami</h2>

        <div class="products">
            <div class="row">
                @if(!empty($produk[0]))
                @foreach ($produk as $valProduk)
                <div class="product-default inner-icon col-lg-3 col-md-4 col-sm-6 mb-4">
                    <figure>
                        <a href="{{ URL::to('produk-detail/'.$valProduk->id) }}">
                            <img src="{{ asset('upload/produk/'.$valProduk->gambar) }}" width="400" height="400"
                                alt="product" class="img-fluid rounded" />
                        </a>
                        <div class="btn-icon-group">
                            <a href="{{ URL::to('add-to-cart/'.$valProduk->id) }}"
                                class="btn-icon product-type-simple"><i class="icon-shopping-cart"></i></a>
                        </div>
                    </figure>
                    <div class="product-details text-center">
                        <h3 class="product-title">
                            <a href="{{ URL::to('produk-detail/'.$valProduk->id) }}">{{ $valProduk->nama_produk }}</a>
                        </h3>
                        <div class="ratings-container">
                            <div class="product-ratings">
                                <span class="ratings" style="width:0%"></span>
                            </div>
                        </div>
                        <div class="price-box">
                            <span class="product-price">{{ number_format($valProduk->harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <!-- Styled "Coming Soon" Section -->
                <div class="col-lg-12 d-flex justify-content-center">
                    <div class="coming-soon-container">
                        <i class="fas fa-clock coming-soon-icon"></i>
                        <p class="coming-soon-text">Coming Soon</p>
                        <p class="coming-soon-subtext">We are currently updating our product list. Please check back
                            soon for new arrivals!</p>
                        <a href="{{ URL::to('/') }}" class="btn btn-primary coming-soon-btn">Back to Home</a>
                    </div>
                </div>
                @endif
            </div>
        </div>

        @if(!empty($produk[0]))
        <div class="d-flex justify-content-center">
            {{ $produk->links('vendor.pagination.bootstrap-4') }}
        </div>
        @endif
    </div>
</div>

@endsection