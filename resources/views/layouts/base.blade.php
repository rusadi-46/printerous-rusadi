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

			<!-- Favicons -->
		<link rel="apple-touch-icon" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
		<link rel="icon" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
		<link rel="icon" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
		<link rel="manifest" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/manifest.json">
		<link rel="mask-icon" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
		<link rel="icon" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/favicon.ico">
		<meta name="theme-color" content="#7952b3">
		<link href="/css/base.css" rel="stylesheet" type="text/css" />

	</head>
	<body class="bg-light">
		<div class="container">
			<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-purple text-white-50" aria-label="Main navigation">
				<div class="container-fluid">
					<a class="navbar-brand" href="/">{{ config('app.name', 'Laravel') }}</a>
					<button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="offcanvas" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>

					<div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
						<ul class="navbar-nav me-auto mb-2 mb-lg-0">
							@if (\Auth::user()->is_admin == true)
								<li class="nav-item">
									<a class="nav-link @if (isset($page) && $page->menu == 'Users') {{'active'}} @endif" href="{{ route('user.index') }}">User</a>
								</li>
							@endif
							<li class="nav-item">
								<a class="nav-link @if (isset($page) && $page->menu == 'Organization') {{'active'}} @endif" href="{{ route('organization.index') }}">Organization</a>
							</li>
						</ul>
						@if (Auth::user())
							<div class="dropdown">
							  	<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
							    	{{Auth::user()->name}}
							  	</button>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
									<form method="POST" action="{{ route('logout') }}">
										@csrf
									    <li><button type="submit" class="dropdown-item">Logout</button></li>
									</form>
								</ul>
							</div>
						@endif
					</div>
				</div>
			</nav>
		</div>
		<main class="container">
			<div class="my-3 p-3">
				<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
					@foreach ($page->breadcrumbs as $breadcrumb)
					    <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}"><a href="{{ $breadcrumb['url'] }}" style="text-decoration: none;">{{ $breadcrumb['title'] }}</a></li>
					@endforeach
				  </ol>
				</nav>
				@yield('content')
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
		<script type="text/javascript">
			(function () {
			  'use strict'

			  	document.querySelector('[data-bs-toggle="offcanvas"]').addEventListener('click', function () {
			    document.querySelector('.offcanvas-collapse').classList.toggle('open')
			  })
			})()
		</script>
		</body>
</html>
