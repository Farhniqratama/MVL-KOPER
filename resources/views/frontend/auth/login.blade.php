@extends('frontend.layouts.default')
@section('title', __( 'Login' ))
@section('content')

<div class="page-header">
    <div class="container d-flex flex-column align-items-center">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Login
                    </li>
                </ol>
            </div>
        </nav>
    </div>
</div>

<div class="container login-container">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading mb-1">
						@include('layouts.partials.notification')
                        <h2 class="title">Login</h2>
                    </div>

                    <form action="{{ URL::to('do-login-user') }}" method="post">
						@csrf
                        <label for="login-email">
							Email address
                            <span class="required">*</span>
                        </label>
                        <input type="email" class="form-input form-wide" name="email" id="login-email" required />

                        <label for="login-password">
                            Password
                            <span class="required">*</span>
                        </label>
                        <input type="password" class="form-input form-wide" name="password" id="login-password" required />

                        <div class="form-footer">
							<div class="custom-control custom-checkbox mb-0">
								<<a href="{{ URL::to('register-user') }}" class="forget-password text-dark "> Lupa Password</a>
							</div>
                            <p class="form-footer-right">Belum Punya Akun?<a href="{{ URL::to('register-user') }}" class="forget-password text-dark form-footer-right"> Register</a></p>
                        </div>
                        <button type="submit" class="btn btn-dark btn-md w-100">
                            LOGIN
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection