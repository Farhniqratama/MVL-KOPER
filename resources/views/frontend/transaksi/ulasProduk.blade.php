@extends('frontend.layouts.default')
@section('title', __( 'Review Produk' ))
@section('content')
<!-- CSS untuk penataan bintang -->
<style type="text/css">
    .rating {
      display: inline-block;
      position: relative;
      height: 50px;
      line-height: 50px;
      font-size: 1.5rem;
      margin-bottom: 15px;
    }

    .rating label {
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      cursor: pointer;
    }

    .rating label:last-child {
      position: static;
    }

    .rating label:nth-child(1) {
      z-index: 5;
    }

    .rating label:nth-child(2) {
      z-index: 4;
    }

    .rating label:nth-child(3) {
      z-index: 3;
    }

    .rating label:nth-child(4) {
      z-index: 2;
    }

    .rating label:nth-child(5) {
      z-index: 1;
    }

    .rating label input {
      position: absolute;
      top: 0;
      left: 0;
      opacity: 0;
    }

    .rating label .icon {
      float: left;
      color: transparent;
      font-size: 1.7rem;
    }

    .rating label:last-child .icon {
      color: #000;
    }

    .rating:not(:hover) label input:checked ~ .icon,
    .rating:hover label:hover input ~ .icon {
      color: gold;
    }

    .rating label input:focus:not(:checked) ~ .icon:last-child {
      color: #000;
      text-shadow: 0 0 5px #09f;
    }
</style>

<!--    breadcrumb-area start    -->
<div class="container checkout-container mt-7">
    <div class="row">
        <div class="col-lg-12">
        <h4>Review Produk</h4>
                <div class="cart-table-container">
                    

                    <div class="row">
                    @foreach ($detail as $key => $value)
                    <div class="col-xl-8 col-lg-8">
                        
                        
                        
                        <div class="blog-standard-details-posts">
                            <div class="blog-details-wrap mb-40">
                                <div class="blog-thumb mb-35">
                                    <a href="#">
                                        <img src="{{ asset('upload/produk/'.$value->gambar) }}" style="width:150px" alt="blog">
                                    </a>
                                </div>
                                <div class="blog-title">
                                    <h3>{{ $value->nama_produk }}</h3>
                                </div>
                                <div class="blog-content">
                                    <p>{{ $value->deskripsi }}</p>
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-10">
                        <div class="sidebar-area">
                            <div class="about-widget-content">
                                <div class="blog-comment-form mb-md-60 mb-xs-60">
                                
                                    <div class="blog-comments-title mb-30">
                                        <h4>Review Produk</h4>
                                    </div>
                                    <div class="comment-form">
                                        <form action="{{ URL::to('do-add-review/'.$value->id) }}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="rating">
                                                        <label>
                                                            <input type="radio" name="stars" value="0">
                                                        </label>
                                                        <label>
                                                            <input type="radio" class="star bintang_1" name="stars" value="1">
                                                            <span class="icon">★</span>
                                                        </label>
                                                        <label>
                                                            <input type="radio" class="star bintang_2" name="stars" value="2">
                                                            <span class="icon">★</span>
                                                            <span class="icon">★</span>
                                                        </label>
                                                        <label>
                                                            <input type="radio" class="star bintang_3" name="stars" value="3">
                                                            <span class="icon">★</span>
                                                            <span class="icon">★</span>
                                                            <span class="icon">★</span>   
                                                        </label>
                                                        <label>
                                                            <input type="radio" class="star bintang_4" name="stars" value="4">
                                                            <span class="icon">★</span>
                                                            <span class="icon">★</span>
                                                            <span class="icon">★</span>
                                                            <span class="icon">★</span>
                                                        </label>
                                                        <label>
                                                            <input type="radio" class="star bintang_5" name="stars" value="5">
                                                            <span class="icon">★</span>
                                                            <span class="icon">★</span>
                                                            <span class="icon">★</span>
                                                            <span class="icon">★</span>
                                                            <span class="icon">★</span>
                                                        </label>
                                                    </div>


                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="input-wrap">
                                                        <textarea name="comment" class="form-control form-control-sm" placeholder="Your Comment" spellcheck="false"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <button class="btn btn-gra" type="submit">
                                                        Review
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- team-area end -->

<script>
    // Menampilkan rating yang dipilih
    const stars = document.querySelectorAll('.rating-stars input');
    const result = document.getElementById('selected-rating');

    stars.forEach(star => {
        star.addEventListener('change', function () {
            result.textContent = `Rating yang dipilih: ${this.value} bintang`;
        });
    });
</script>

@endsection