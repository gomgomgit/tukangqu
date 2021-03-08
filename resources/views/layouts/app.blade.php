<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
	<link rel="stylesheet" type="text/css" href="{{ asset('deskapp/src/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('deskapp/src/plugins/datatables/css/responsive.bootstrap4.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('deskapp/vendors/styles/style.css') }}">

	@yield('link')

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-119386393-1');
	</script>

  <script>
    window.Laravel = {!! json_encode([
      'csrfToken' => csrf_token(),
    ]) !!};
  </script>
</head>
<body>
  
  {{-- @include('layouts.preload') --}}

	@include('layouts.header')
	
	@include('layouts.settings')

	@include('layouts.sidebar')
  
	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="pd-ltr-20">

			@yield('main-content')

		</div>
	</div>
	<!-- js -->
	<script src="{{ asset('deskapp/vendors/scripts/core.js') }}"></script>
	<script src="{{ asset('deskapp/vendors/scripts/script.min.js') }}"></script>
	<script src="{{ asset('deskapp/vendors/scripts/process.js') }}"></script>
	<script src="{{ asset('deskapp/vendors/scripts/layout-settings.js') }}"></script>
	<script src="{{ asset('deskapp/src/plugins/apexcharts/apexcharts.min.js') }}"></script>
	<script src="{{ asset('deskapp/src/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('deskapp/src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('deskapp/src/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset('deskapp/src/plugins/datatables/js/responsive.bootstrap4.min.js') }}"></script> 
	<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


  <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
  <script>

   var pusher = new Pusher('{{env("MIX_PUSHER_APP_KEY")}}', {
      cluster: '{{env("PUSHER_APP_CLUSTER")}}',
      encrypted: true
    });

    var channel = pusher.subscribe('survey-notify-channel');
    channel.bind('App\\Events\\SurveyNotify', function(data) {
			const ev = new CustomEvent('notif', { detail: {title: data.title, message:data.message }})
			window.dispatchEvent(ev)
			console.log(data)
    });
	</script>
	@yield('script')

</body>
</html>