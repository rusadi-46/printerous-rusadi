<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
	<meta name="generator" content="Hugo 0.79.0">
	<title>{{ config('app.name', 'Laravel') }}</title>

	<link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/offcanvas/">
	  <!-- Bootstrap core CSS -->
	<link href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/c1b28119fd.js" crossorigin="anonymous"></script>
	<link href="/css/login.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="bg-light">
	<main class="container">
	  	<div class="wrapper fadeInDown">
			<div id="formContent">
			 	<div class="fadeIn first">
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
	</main>
	
	<script src="https://getbootstrap.com/docs/5.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<script src="/js/mixins.js" type="text/javascript"></script>
		@if (session('message'))
			<script>
				Toast.fire({
					icon: '{{ session('state') ?? 'success' }}',
					title: '{{ session('message') }}'
				})
			</script>
		@endif
	</body>
</html>
