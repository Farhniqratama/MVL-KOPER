@extends('frontend.layouts.default')
@section('title', __( 'Home' ))
@section('content')

<div class="tiva-slideshow-wrapper">
	<div id="tiva-slideshow" class="nivoSlider">
		<a href="#" title="Slideshow image"><img class="img-responsive" src="{{ asset('byhands') }}/img/slide/slide1-h1.jpg" title="#caption1" alt="Slideshow image"></a>
		<a href="#" title="Slideshow image"><img class="img-responsive" src="{{ asset('byhands') }}/img/slide/slide2-h1.jpg" title="#caption2" alt="Slideshow image"></a>
	</div>
	
	<div id="caption1" class="nivo-html-caption">
		<div class="tiva-caption">
			<div class="left-right hidden-xs medium_yellow_16"><span>Accessories</span></div>
			<div class="left-right hidden-xs normal very_large_60">Floral headband</div>
			<div class="left-right  hidden-md hidden-sm hidden-xs slow medium_16">when an unknown printer took a galley of type and scrambled it to <br>make a type specimen book. It has survived not only five centuries, <br>but also the leap into electronic typesetting, remaining.</div>
			<div class="left-right hidden-xs slow"><a class="btn button btn-now" href="{{ URL::to('list-produk') }}" title="Shop now">Shop now</a></div>
		</div>
	</div>
	<div id="caption2" class="nivo-html-caption">
		<div class="tiva-caption">
			<div class="left-right hidden-xs medium_yellow_16"><span>Accessories</span></div>
			<div class="left-right hidden-xs normal very_large_60">Floral headband</div>
			<div class="left-right  hidden-md hidden-sm hidden-xs slow medium_16">when an unknown printer took a galley of type and scrambled it to <br>make a type specimen book. It has survived not only five centuries, <br>but also the leap into electronic typesetting, remaining.</div>
			<div class="left-right hidden-xs slow"><a class="btn button btn-now" href="{{ URL::to('list-produk') }}" title="Shop now">Shop now</a></div>
		</div>
	</div>
</div><!-- end tiva-slideshow-wrapper -->

<div id="columns" class="columns-container">
	<div class="section section-tabsproduct">
		<div class="container">
			<!-- tabs-top -->
			<div class="tabs-top block">
				<div class="block-title">
					<h4 class="title_block">Galeri</h4>
				</div><!--end title -->

				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="kk_">
						<div class="block_content">
							<div class="row">
								@foreach($galeri as $kg => $vg)
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-sp-12">
									<div class="product-container">
										<div class="left-block">
											<div class="product-image-container">
												<a class="product_img_link" href="{{ asset('upload/galeri/'.$vg->gambar) }}" title="Galeri">
													<img src="{{ asset('upload/galeri/'.$vg->gambar) }}" alt="Galeri" class="img-responsive" width="480" height="640" style="height: 330px !important;">
												</a>
											</div>
										</div><!--end left block -->
									</div><!-- end product-container-->
								</div>
								@endforeach
								<nav style="float: right;font-size: 17px;">
									{{ $galeri->links() }} 
								</nav>
							</div><!-- end row -->
						</div><!-- end block_content -->
					</div>
				</div>
			</div><!-- end tabs-top -->
		</div><!-- end container -->
	</div><!-- end section-tabsproduct -->
</div><!--end columns -->

@endsection