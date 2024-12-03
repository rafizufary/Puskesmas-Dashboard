<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Puskesmas Kecamatan pesanggrahan</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="{{ asset('assets/img/logo_puskesmas.png') }}" type="image/x-icon"/>

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
	
	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/azzara.min.css') }}">
	</head>
	<body class="login">
	<div class="wrapper wrapper-login">
		<div class="container container-login animated fadeIn">
			<h3 class="text-center">Silakan Login</h3>
			<div class="login-form">

                <form method="POST" action="{{ route('login') }}" enctype="multipart/form-data">

                @csrf
				<div class="form-group form-floating-label">
					<input id="email" name="email" type="email" class="form-control input-border-bottom" required autofocus>
					<label for="email" class="placeholder">Email</label>
				</div>
				<div class="form-group form-floating-label">
					<input id="password" name="password" type="password" class="form-control input-border-bottom" required autofocus>
					<label for="password" class="placeholder">Password</label>
					<div class="show-password">
						<i class="flaticon-interface"></i>
					</div>
				</div>
				
				<div class="form-action mb-3">
					<button type="submit" class="btn btn-primary btn-rounded btn-login">Sign In</button>
				</div>

			</form>
			</div>
		</div>
	</div>
	<script src="{{ asset('assets/js/core/jquery.3.2.1.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
	<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
	<script src="{{ asset('assets/js/ready.js') }}"></script>
	<script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>


	<!--jika session error akan menampilkan alert error-->

	@if(session('error'))
	<script>
		var SweetAlert2Demo = function(){
			var initDemos = function(){

				swal({
					title:"{{session('error')}}",
					text:"Silakan Periksa Kembali Email Dan Password",
					icon : "error",
					buttons : {
						confirm: {
							text : "Tutup",
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

	</body>
</html>