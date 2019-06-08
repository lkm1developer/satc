<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}>
	<head>
		<meta charset="utf-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="base_url" content="{{url('/')}}">

		<title>{{ config('app.name', 'Laravel') }}</title>

		<!-- Scripts -->
		
		
		
		<link href="{{ asset('public/admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="{{ asset('public/admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="{{ asset('public/admin/vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('public/admin/css/sb-admin.css') }}" rel="stylesheet">

  </head>
  <body class="bg-dark">

    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Login</div>
        <div class="card-body">
		@if ($errors)
                                    <span style="display:block !important"class="invalid-feedback">
                                        <strong>{{ $errors}}</strong>
                                    </span>
                             @endif
          <form method="POST" action="{{ route('adminlogin') }}">
				{{   csrf_field()}}
            <div class="form-group">
              <div class="form-label-group">
                <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required="required"name="email" autofocus="autofocus">
                <label for="inputEmail">Email address</label>
				
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required="required">
                <label for="inputPassword">Password</label>
				
							
              </div>
            </div>
            <!--<div class="form-group">
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="remember-me">
                  Remember Password
                </label>
              </div>
            </div>-->
			<input class="btn btn-primary btn-block"type="submit" value="Login" name="login">
           
          </form>
         <!-- <div class="text-center">
            <a class="d-block small mt-3" href="register.html">Register an Account</a>
            <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
          </div>-->
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('public/admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('public/admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Page level plugin JavaScript-->
    <script src="{{ asset('public/admin/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/datatables/dataTables.bootstrap4.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('public/admin/js/sb-admin.min.js') }}"></script>

    <!-- Demo scripts for this page-->
    <script src="{{ asset('public/admin/js/demo/datatables-demo.js') }}"></script>
    <script src="{{ asset('public/admin/js/demo/chart-area-demo.js') }}"></script>

  </body>

</html>
