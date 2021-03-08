<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>DeskApp - Bootstrap Admin Dashboard HTML Template</title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/logo.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/logo.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/logo.png') }}">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="{{ asset('deskapp/vendors/styles/core.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('deskapp/vendors/styles/icon-font.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('deskapp/vendors/styles/style.css') }}">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-119386393-1');
	</script>
</head>
<body class="login-page">
	<div class="login-header box-shadow">
		<div class="container-fluid d-flex justify-content-between align-items-center">
			<div class="brand-logo">
				<a href="login.html">
					<img src="{{ asset('image/Logo-w-name.png') }}" alt="">
				</a>
			</div>
			<div class="login-menu">
				<ul>
					{{-- <li><a href="register.html">Register</a></li> --}}
				</ul>
			</div>
		</div>
	</div>
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 col-lg-7">
					<img src="{{ asset('deskapp/vendors/images/login-page-img.png') }}" alt="">
				</div>
				<div class="col-md-6 col-lg-5">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title text-center">
							<img width="50%" src="{{ asset('image/Logo-w-name.png') }}" alt="">
							<h2 class="text-center text-primary mt-4">Login</h2>
						</div>
            <form action="{{ Route('admin.loginProcess') }}" method="POST">
              @csrf
							{{-- <div class="select-role">
								<div class="btn-group btn-group-toggle" data-toggle="buttons">
									<label class="btn active">
										<input type="radio" name="options" id="admin">
										<div class="icon"><img src="{{ asset('deskapp/vendors/images/briefcase.svg') }}" class="svg" alt=""></div>
										<span>I'm</span>
										Manager
									</label>
									<label class="btn">
										<input type="radio" name="options" id="user">
										<div class="icon"><img src="{{ asset('deskapp/vendors/images/person.svg') }}" class="svg" alt=""></div>
										<span>I'm</span>
										Employee
									</label>
								</div>
              </div> --}}
               @if($errors->any())
                <div class="text-left">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
              @endif

              @if (session('error'))
                <ul>
                    <li class="text-danger">{{ session('error') }}</li>
                </ul>
              @endif
							<div class="input-group custom">
								<input type="text" class="form-control form-control-lg" placeholder="Name" name="name" value="{{ old('name') }}">
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
								</div>
							</div>
							<div class="input-group custom">
								<input type="password" class="form-control form-control-lg" placeholder="**********" name="password" value="{{ old('password') }}">
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
								</div>
							</div>
							<div class="row pb-30">
								<div class="col-6">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck1" name="remember">
										<label class="custom-control-label" for="customCheck1">Remember</label>
									</div>
								</div>
								<div class="col-6">
									<div class="custom-control custom-checkbox"  onclick="permission()">
										<input type="checkbox" class="custom-control-input" id="permission">
										<label class="custom-control-label" for="permission">Izinkan Notifikasi</label>
									</div>
								</div>
								{{-- <div class="col-6">
									<div class="forgot-password"><a href="forgot-password.html">Forgot Password</a></div>
								</div> --}}
							</div>
							<div>
								{{-- <span>Name: Admin1 / Admin2 </span>
								<p>Password: masukaja </p> --}}
								<p class="w-75">Beri izin notifikasi untuk mendapatkan notifikasi survei</p>
							</div>
							{{-- <div class="row mb-3">
								<div class="col-12 text-center">
									<button @click.prevent="permission()" class="btn btn-sm btn-info">Izinkan Notifikasi</button>
								</div>
							</div> --}}
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group mb-0">
										<!--
											use code for form submit
											<input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
										-->
										<button type="submit" class="btn btn-primary btn-lg btn-block">Sign In</button>
									</div>
									{{-- <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">OR</div>
									<div class="input-group mb-0">
										<a class="btn btn-outline-primary btn-lg btn-block" href="register.html">Register To Create Account</a>
									</div> --}}
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- js -->
	<script src="{{ asset('deskapp/vendors/scripts/core.js') }}"></script>
	<script src="{{ asset('deskapp/vendors/scripts/script.min.js') }}"></script>
	<script src="{{ asset('deskapp/vendors/scripts/process.js') }}"></script>
	<script src="{{ asset('deskapp/vendors/scripts/layout-settings.js') }}"></script>
	<script>
		function permission() {
        Notification.requestPermission().then(function(permission) { console.log('permiss', permission)});
		}
	</script>
</body>
</html>