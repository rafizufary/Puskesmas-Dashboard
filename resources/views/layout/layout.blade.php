<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Puskesmas Kecamatan Pesanggrahan</title>
	<meta name="csrf-token" content="{{csrf_token() }}">
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="{{ asset('assets/img/logo_puskesmas.png') }}" type="image/x-icon"/>
	<!-- <link rel="icon" href="/assets/img/icon.ico" type="image/x-icon"/> -->

	
	<!-- Fonts and icons -->
	<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
	<script>
		WebFont.load({
			google: {"families":["Open+Sans:300,400,600,700"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"], urls: ['{{ asset("assets/css/fonts.css") }}']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- date -->
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/azzara.min.css') }}">
	

	<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">

	<!-- Leaflet -->
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
	<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

	<!-- data table -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

	
	
	<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />



	@yield('contentCss')
	
</head>
<body>
	<div class="wrapper">
		<!--
				Tip 1: You can change the background color of the main header using: data-background-color="blue | purple | light-blue | green | orange | red"
		-->
		<div class="main-header" data-background-color="light-blue">
			<!-- Logo Header -->
			<div class="logo-header">
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="fa fa-bars"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="fa fa-ellipsis-v"></i></button>
				<div class="navbar-minimize">
					<button class="btn btn-minimize btn-rounded">
						<i class="fa fa-bars"></i>
					</button>
				</div>
			</div>
			<!-- End Logo Header -->

			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg">
				
				<div class="container-fluid">
				 	<h2 style="color: white;"><b>E-Control Puskesmas Kecamatan Pesanggrahan</b></h2>
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						<li class="nav-item toggle-nav-search hidden-caret">
							<a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
								<i class="fa fa-search"></i>
							</a>
						</li>
						
						<li class="nav-item dropdown hidden-caret">
						<li class="nav-item dropdown hidden-caret">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
								<div class="avatar-sm">
									<img src="{{ asset('assets/img/logo_puskesmas.png') }}" alt="..." class="avatar-img rounded-circle">
								</div>
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<li>
									<div class="user-box">
										<div class="avatar-lg"><img src="{{ asset('assets/img/logo_puskesmas.png') }}" alt="image profile" class="avatar-img rounded"></div>
										<div class="u-text">
											<h4>{{auth()->user()->name}}</h4>
											@if(Auth::user()->level != 'super_admin')
												<p class="text-muted">{{auth()->user()->level}} - Poli {{auth()->user()->poli->nama_poli}}</p>
											@else
												<p class="text-muted">{{auth()->user()->level}}</p>
											@endif
										</div>
									</div>
								</li>
								<li>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="{{ route('detailUser') }}"><i class="fa fa-user"></i> My Profile</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"><i class="fa fa-lock"></i> Logout</a>
										<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
											@csrf
										</form>
								</li>
							</ul>
						</li>

					</ul>
				</div>
			</nav>
			<!-- End Navbar -->
		</div>
		<!-- Sidebar -->
		<div class="sidebar">
			
			<div class="sidebar-wrapper scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							<img src="{{ asset('assets/img/logo_puskesmas.png') }}" alt="..." class="avatar-img rounded-circle">
						</div>
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span style="color: black;">
									<h4>{{auth()->user()->name}}</h4>	
										@if(auth::user()->level != 'super_admin')
											{{auth()->user()->level}} - Poli {{auth()->user()->poli->nama_poli}}</span>
										@else
											{{auth()->user()->level}}</span>
										@endif
								</span>
							</a>		
						</div>
					</div>
					<ul class="nav">
						<li class="nav-item @yield('dashboard')">
							<a href="{{ route('home') }}">
								<i class="fas fa-home"></i>
								<p>Dashboard</p>
							</a>
						</li>
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">Components</h4>
						</li>

						@if (auth()->user()->level == 'super_admin')
				
						<li class="nav-item @yield('user')">
							<a href="{{ route('user') }}">
								<i class="fas fa-user"></i>
								<p>User</p>
							</a>
						</li>

						@endif

						<li class="nav-item @yield('pasien')">
							<a href="{{ route('pasien') }}">
								<i class="fas fa-users"></i>
								<p>Pasien</p>
							</a>
						</li>

						<li class="nav-item @yield('diagnosa')">
							<a href="{{ route('diagnosa') }}">
								<i class="fas fa-swatchbook"></i>
								<p>Diagnosa</p>
							</a>
						</li>

						@if (auth()->user()->level == 'super_admin')

						<li class="nav-item @yield('poli')">
							<a href="{{ route('poli') }}">
								<i class="fas fa-hospital-alt"></i>
								<p>Poli</p>
							</a>
						</li>

						@endif

						<li class="nav-item @yield('rawatJalan')">
							<a href="{{ route('rawatjalan') }}">
								<i class="fas fa-wheelchair"></i>
								<p>Rawat Jalan</p>
							</a>
						</li>

						<li class="nav-item @yield('historyRawatJalan')">
							<a href="{{ route('history') }}">
								<i class="fas fa-id-card"></i>
								<p>History Rawat Jalan</p>
							</a>
						</li>

						<li class="nav-item @yield('pemetaan')">
							<a href="{{ route('pemetaan.index') }}">
								<i class="fas fa-globe-asia"></i>
								<p>Pemetaan</p>
							</a>
						</li>

						{{-- <li class="nav-item @yield('verifikasi')">
							<a href="/verifikasi">
								<i class="fas fa-swatchbook"></i>
								<p>Verifikasi</p>
							</a>
						</li> --}}

					</ul>
				</div>
			</div>
		</div>
		@yield('content')
		
		
	<!--   Core JS Files   -->
	<!-- <script src="/assets/js/core/jquery.3.2.1.min.js"></script> -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
	<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
	<!-- jQuery UI -->
	<script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>
	<!-- Bootstrap Toggle -->
	<script src="{{ asset('assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js') }}"></script>
	<!-- jQuery Scrollbar -->
	<script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
	<!-- Datatables -->
	<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>
	<!-- Azzara JS -->
	<script src="{{ asset('assets/js/ready.min.js') }}"></script>
	<!-- Azzara DEMO methods, don't include it in your project! -->
	<script src="{{ asset('assets/js/setting-demo.js') }}"></script>

	<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

	<script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

	<!-- data table -->
	<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

	<!-- date -->
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>    

		@if(session('success'))
		<script>
			var SweetAlert2Demo = function(){
				var initDemos = function(){

					swal({
						title:"Success",
						text:"{{session('success')}}",
						icon : "success",
						buttons : {
							confirm: {
								text : "Confirm Me",
								value : true,
								visible : true,
								className : "btn btn-success",
								closeModal : true
							}
						}
					});
				};
				return {
					init: function(){
						initDemos();
					},
				};
			}();

			jQuery(document).ready(function(){
				SweetAlert2Demo.init();
			});
		</script>

		@endif

		@if(session('error'))
		<script>
			var SweetAlert2Demo = function(){
				var initDemos = function(){

					swal({
						title:"Error",
						text:"{{session('error')}}",
						icon : "error",
						buttons : {
							confirm: {
								text : "Confirm Me",
								value : true,
								visible : true,
								className : "btn btn-danger",
								closeModal : true
							}
						}
					});
				};
				return {
					init: function(){
						initDemos();
					},
				};
			}();

			jQuery(document).ready(function(){
				SweetAlert2Demo.init();
			});
		</script>

		@endif

	<script >
		$(document).ready(function() {
			$('#add-row').DataTable();
        });
	</script>

	<!-- date -->
	<script>
	$(document).ready(function() {
		$(".input_tanggal").datepicker({
			dateFormat: "yy-mm-dd", // Format tanggal yang diinginkan
			changeMonth: true,
			changeYear: true,
			yearRange: "1900:2100" // Rentang tahun yang diizinkan
		});
	});
	</script>

	<!-- <script>
        $(document).ready(function() {
            $('.exampleFormControlSelect1').select2();
        });
    </script> -->


	
	@yield('contentjs')

</body>
</html> 