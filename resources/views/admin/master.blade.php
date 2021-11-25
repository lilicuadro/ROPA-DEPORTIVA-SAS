<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> @yield('title') ROPA DEPORTIVA SAS</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="routeName" content="{{ Route::currentRouteName()}}">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

	<link rel="stylesheet" href="{{url('/static/css/admin.css?v='.time())}}">

	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/b0d8aefb17.js" crossorigin="anonymous"></script> 

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="{{url('/static/libs/ckeditor/ckeditor.js')}}"></script>
	<script src="{{url('/static/js/admin.js')}}"></script>
	<script >
		$(document).ready(function(){
			$('[data-bs-toggle="tooltip"]').tooltip()
		});

	</script>
</head>
<body>

	<div class="wrapper">
		<div class="col1">@include('admin.sidebar')</div>
		<div class="col2">
			<nav class="navbar navbar-expand-lg shadow">
				<div class="collapse navbar-collapse">
					<ul class="navbar-nav">
						<li class="nav.item">
							<a href="{{url('/admin')}}" class="nav-link">
								<i class="fas fa-home"></i>Dashboard</a>
						</li>
					</ul>
				</div>
			</nav>

			<div class="page">
				<div class="container-fluid">
					<nav aria-label="breadcrumb shadow">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="{{url('/admin')}}"><i class="fas fa-home"></i> Dashboard</a>
							</li>
							@section('breadcrumb')
							@show
						</ol>
					</nav>
				</div>
			@if(Session::has('message'))
				<div class="container-fluid">
					<div class="alert alert-{{Session::get('typealert')}} mtop16" style="display:block; margin-bottom: 16px;">
						{{Session::get('message')}}
						@if($errors->any())
						<ul>
							@foreach($errors->all() as $error)
							<li> {{$error}}</li>
							@endforeach
						</ul>
						@endif
						<script>
							$('.alert').slideDown();
							setTimeout(function(){$('.alert').slideUp();}, 10000);
						</script>
					</div>	
				</div>
				@endif

				@section('content')
				@show
			
				
			</div>
		</div>
		
	</div>

</body>
</html>