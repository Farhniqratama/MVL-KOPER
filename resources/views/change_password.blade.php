@extends('layouts.default')
@section('title', __( 'Rubah Password' ))
@section('content')
@include('layouts.partials.notifications')
<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">Rubah Password</h3>
    </div>
    <form method="POST" action="{{ URL::to('/do-change-password') }}">
        @csrf
        <div class="card-body">
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Password</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" placeholder="Password" name="password" required="">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary">Rubah</button>
        </div>
    </form>
</div>
@endsection
