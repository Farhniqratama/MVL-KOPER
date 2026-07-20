@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible" role="alert">
  	{{ $message }}
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
  	{{ $message }}
</div>
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-dismissible" role="alert">
  	{{ $message }}
  	</button>
</div>
@endif

@if ($message = Session::get('info'))
<div class="alert alert-info alert-dismissible" role="alert">
  	{{ $message }}
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger alert-dismissible" role="alert">
  	{{ $message }}
</div>
@endif