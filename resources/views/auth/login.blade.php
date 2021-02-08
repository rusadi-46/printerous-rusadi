@extends('layouts.auth')

@section('content')
<div class="wrapper fadeInDown">
	<div id="formContent">
	 	<div class="fadeIn first mt-4">
			<img src="https://cdn2.hubspot.net/hub/5582296/hubfs/Logo%20Printerous.png?height=120&name=Logo%20Printerous.png" id="icon" alt="User Icon" />
	  	</div>
	  	<form method="POST"  action="{{ route('login') }}">
			@csrf
			<input type="text" id="login" class="form-control fadeIn second @error('email') is-invalid @enderror" name="email" placeholder="email">
			@error('email')
			   <div class="invalid-feedback">{{ $message }}</div>
			@enderror

			<input type="password" id="password" class="form-control fadeIn third @error('password') is-invalid @enderror" name="password" placeholder="password">
			@error('password')
			   <div class="invalid-feedback">{{ $message }}</div>
			@enderror
			<div class="py-4">
			  <button type="submit" class="btn btn-primary fadeIn fourth" value="Log In"> Login</button>
			</div>
	  	</form>
	</div>
</div>
@endsection