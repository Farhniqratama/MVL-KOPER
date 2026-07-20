@extends('frontend.layouts.default')
@section('title', __( 'Home' ))
@section('content')

<div class="pagehding-sec">
	<div class="images-overlay"></div>		
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-heading">
					<h1>my account</h1>
				</div>
				<div class="breadcrumb-list">
					<ul>
						<li><a href="{{ URL::to('/') }}">Home</a></li>
						<li><a href="#">page</a></li>
						<li><a href="#">my account</a></li>
					</ul>
				</div>					
			</div>				
		</div>
	</div>
</div>
<!-- Page Heading Section End -->	

<div id="columns" class="columns-container account-page-area pt-100">
	<!-- container -->
	<div class="container">
		<div class="row">
			@include('layouts.partials.notification')
			<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
				<form action="{{ URL::to('do-check-email') }}" method="post" id="form-account-creation" class="form-horizontal box panel panel-default">
					@csrf
					<h3 class="panel-heading">Check Your Email</h3>
					<div class="form_content panel-body clearfix">
						<div class="form-group required">
							<div class="col-lg-12">
								<label for="email">Email address <sup>*</sup></label>
								<input type="email" class="form-control" id="email" name="email" required>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-12">
								<button class="btn button btn-success">Check</button>
								<p class="pull-right required"><span><sup>*</sup>Required field</span></p>
							</div>
						</div>
					</div>
				</form><!--end form -->
			</div>
		</div>
	</div> <!-- end container -->
</div><!--end columns -->
@endsection