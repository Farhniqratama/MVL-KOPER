@extends('frontend.layouts.default')
@section('title', __( 'Detail Produk' ))
@section('content')

<div class="container-fluid">
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Detail Produk</a></li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-lg-12 main-content product-sidebar-right">
            <div class="product-single-container product-single-default">
                <div class="cart-message d-none">
                    <strong class="single-cart-notice">“{{ $produk->nama_produk }}”</strong>
                </div>

                <div class="row">
                    <div class="col-md-6 product-single-gallery">
                        <div class="product-slider-container">
                            <div class="product-single-carousel owl-carousel owl-theme show-nav-hover">
                                @foreach ($images as $key => $valImages)
                                <div class="product-item">
                                    <img class="product-single-image" src="{{ asset('upload/produk/'.$valImages->gambar) }}" data-zoom-image="{{ asset('upload/produk/'.$valImages->gambar) }}" width="468" height="468" alt="product" />
                                </div>
                                @endforeach
                                
                            </div>
                            <!-- End .product-single-carousel -->
                            <span class="prod-full-screen">
                                <i class="icon-plus"></i>
                            </span>
                        </div>

                        <div class="prod-thumbnail owl-dots">
                            @foreach ($images as $keys => $valsImages)
                            <div class="owl-dot">
                                <img src="{{ asset('upload/produk/'.$valsImages->gambar) }}" width="110" height="110" alt="product-thumbnail" />
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- End .product-single-gallery -->

                    <div class="col-md-6 product-single-details">
                        <h1 class="product-title">{{ $produk->nama_produk }}</h1>
                        <div class="ratings-container">
                            <div class="product-ratings">
                                <span class="ratings" style="width:25%"></span>
                                <!-- End .ratings -->
                                <span class="tooltiptext tooltip-top"></span>
                            </div>
                            <!-- End .product-ratings -->

                            <a href="#" class="rating-link">( 6 Reviews )</a>
                        </div>
                        <!-- End .ratings-container -->

                        <hr class="short-divider">

                        <div class="price-box">
                            <span class="new-price">{{ number_format($produk->harga, 0, ',', '.') }}</span>
                        </div>
                        <!-- End .price-box -->

                        <div class="product-desc">
                            <p>
                                {{ $produk->deskripsi }}
                            </p>
                        </div>
                        <!-- End .product-desc -->

                        <ul class="single-info-list">
                            <!---->
                            <li>
                                KATEGORI:
                                <strong>
                                    <a href="#" class="product-category">{{ $kategori->nama_kategori }}</a>
                                </strong>
                            </li>
                        </ul>
                        <form action="{{ URL::to('add-to-keranjang') }}" method="post">
                            @csrf
                        <div class="product-action">
                            <div class="product-single-qty">
                                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                <input class="horizontal-quantity form-control" name="qty" type="text">
                            </div>
                            <!-- End .product-single-qty -->

                            <button type="submit" class="btn btn-dark icon-shopping-cart mr-2" title="Add to Cart">Add to Cart</button>
                        </div>


                        </form>
                        <!-- End .product-action -->

                        <hr class="divider mb-0 mt-0">
                        <!-- End .product single-share -->
                    </div>
                    <!-- End .product-single-details -->
                </div>
                <!-- End .row -->
            </div>
            <!-- End .product-single-container -->

            <div class="product-single-tabs">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="product-tab-desc" data-toggle="tab" href="#product-desc-content" role="tab" aria-controls="product-desc-content" aria-selected="true">Deskripsi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-tab-reviews" data-toggle="tab" href="#product-reviews-content" role="tab" aria-controls="product-reviews-content" aria-selected="false">Review</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel" aria-labelledby="product-tab-desc">
                        <div class="product-desc-content">
                            <p>{{ $produk->deskripsi }}</p>
                        </div>
                        <!-- End .product-desc-content -->
                    </div>

                    <div class="tab-pane fade" id="product-reviews-content" role="tabpanel" aria-labelledby="product-tab-reviews">
                        @if(!empty($review))
                        <div class="product-reviews-content">
                            <h3 class="reviews-title">{{ count($review) }} review for {{ $produk->nama_produk }}</h3>
                            @foreach ($review as $key => $valReview)
                            @php
                            $old_date = $valReview->created_at;
                            $old_date_timestamp = strtotime($old_date);
                            $new_date = date('Y-m-d', $old_date_timestamp); 
                            @endphp
                            <div class="comment-list">
                                <div class="comments">
                                    <figure class="img-thumbnail">
                                        <img src="https://portotheme.com/html/porto_ecommerce/assets/images/blog/author.jpg" alt="author" width="80" height="80">
                                    </figure>

                                    <div class="comment-block">
                                        <div class="comment-header">
                                            <div class="comment-arrow"></div>

                                            <div class="ratings-container float-sm-right">
                                                <div class="product-ratings">
                                                    <?php
                                                    if($valReview->rating == 1){
                                                        $width = '20%';
                                                    }elseif($valReview->rating == 2){
                                                        $width = '40%';
                                                    }elseif($valReview->rating == 3){
                                                        $width = '60%';
                                                    }elseif($valReview->rating == 4){
                                                        $width = '80%';
                                                    }else{
                                                        $width = '100%';
                                                    }
                                                    ?>
                                                    <span class="ratings" style="width:{{ $width }}"></span>
                                                    <!-- End .ratings -->
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <!-- End .product-ratings -->
                                            </div>

                                            <span class="comment-by">
                                                <strong>{{ $valReview->nama }}</strong> – {{ tgl_indo($new_date) }}
                                            </span>
                                        </div>

                                        <div class="comment-content">
                                            <p>{{ $valReview->review }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                        </div>
                        @else
                        <div class="comment-list">
                            <div class="comments"><p>Belum ada Review</p></div>
                        </div>
                        @endif
                        <!-- End .product-reviews-content -->
                    </div>
                    <!-- End .tab-pane -->
                </div>
                <!-- End .tab-content -->
            </div>
            <!-- End .product-single-tabs -->
            <!-- End .product-single-tabs -->
        </div>
        <!-- End .col-lg-12 -->

        
    </div>
    <!-- End .row -->

    <div class="products-section pt-0">
        <h2 class="section-title">Related Products</h2>

        <div class="products-slider owl-carousel owl-theme dots-top dots-small">
            @foreach ($produkLainya as $valProdukLainya)
            <div class="product-default">
                <figure>
                    <a href="{{ URl::to('produk-detail/'.$valProdukLainya->id) }}">
                        <img src="{{ asset('upload/produk/'.$valProdukLainya->gambar) }}" width="280" height="280" alt="product">
                    </a>
                </figure>
                
                <div class="product-details">
                    <div class="category-list">
                        <a href="#" class="product-category">{{ $valProdukLainya->nama_kategori }}</a>
                    </div>
                    <h3 class="product-title">
                        <a href="{{ URl::to('produk-detail/'.$valProdukLainya->id) }}">{{ $valProdukLainya->nama_produk }}</a>
                    </h3>
                    <div class="ratings-container">
                        <div class="product-ratings">
                            <span class="ratings" style="width:80%"></span>
                            <!-- End .ratings -->
                            <span class="tooltiptext tooltip-top"></span>
                        </div>
                        <!-- End .product-ratings -->
                    </div>
                    <!-- End .product-container -->
                    <div class="price-box">
                        <span class="product-price">{{ number_format($valProdukLainya->harga, 0, ',', '.') }}</span>
                    </div>
                    <!-- End .price-box -->
                    <div class="product-action">
                        <a href="{{ URL::to('add-to-cart/'.$valProdukLainya->id) }}" class="btn-icon btn-add-cart"><i class="fa fa-arrow-right"></i><span>ADD TO CART</span></a>
                    </div>
                </div>
                <!-- End .product-details -->
            </div>
            @endforeach
        </div>
        <!-- End .products-slider -->
    </div>
    <!-- End .products-section -->

    <hr class="mt-0 m-b-5" />
</div>
<!-- End .container -->

@endsection