@extends('layouts.auth')

@section('content')
<div class="wrapper fadeInDown" style="padding: 100px !important">
	<div id="formContent">
	 	<div class="fadeIn first mt-4">
			<img src="https://cdn2.hubspot.net/hub/5582296/hubfs/Logo%20Printerous.png?height=120&name=Logo%20Printerous.png" id="icon" alt="User Icon" />
	  	</div>
	  	<h4 class="py-4">Register User</h4>
	  	<form method="POST"  action="{{ route('register') }}">
			@csrf
			<input type="text" id="login" class="form-control fadeIn @error('name') is-invalid @enderror" name="name" placeholder="name" required>
			@error('email')
			   <div class="invalid-feedback">{{ $message }}</div>
			@enderror
			<input type="text" id="login" class="form-control fadeIn @error('email') is-invalid @enderror" name="email" placeholder="email" required>
			@error('email')
			   <div class="invalid-feedback">{{ $message }}</div>
			@enderror

			<input type="password" id="password" class="form-control fadeIn @error('password') is-invalid @enderror" name="password" placeholder="password">
			@error('password')
			   <div class="invalid-feedback">{{ $message }}</div>
			@enderror
			<input type="password" id="password" class="form-control fadeIn " name="password_confirmation" placeholder="Password Confirmation">
			<div class="py-4">
			  <button type="submit" class="btn btn-primary fadeIn fourth" value="Log In"> Submit</button>
			</div>
	  	</form>
	</div>
</div>
@endsection