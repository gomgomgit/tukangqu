<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>DeskApp - Bootstrap Admin Dashboard HTML Template</title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('deskapp/vendors/images/apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('deskapp/vendors/images/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('deskapp/vendors/images/favicon-16x16.png') }}">

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


	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-119386393-1');
	</script>
</head>
<body>
  <div class="py-5 position-relative h-100 w-100">
    <div class="pd-20 card-box container m-auto position-absolute"
      style=" top: 50%; left: 50%;
              transform:translate(-50%, -50%)
              ">
      <div class="text-center py-5">
        <h4 class="text-blue h1">Berhasil Membuat Request Proyek</h4>
        <p class="">Terimakasih telah mempercayakan proyek anda pada kami</p>
        <a href="{{ route('createProject') }}" class="btn btn-primary mt-5 px-5">Kembali</a>
      </div>
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

</body>
</html>