<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="base_url" content="{{url('/')}}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->

	<link rel="stylesheet" href="{{ asset('/public/fonts/stylesheet.css') }}">
	<link rel="stylesheet" href="{{ asset('/public/css/animate.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/public/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<link href="{{ asset('/public/css/stylep.css') }}" rel="stylesheet">
	<link href="{{ asset('/public/css/stylep1.css') }}" rel="stylesheet">
	<link href="{{ asset('/public/css/form-elements.css') }}" rel="stylesheet">
	
			
		<link rel="stylesheet" href="{{ asset('/public/css/form-elements.css')}}">
		
    <link href="{{ asset('/public/js/morris/morris-0.4.3.min.css')}}" rel="stylesheet" />
	<link rel="icon" href="{{ asset('/public/images/logo_fevicon.png')}}" type="image/png">
	
</head>
<body>

	<div id="wrapper">
		<div class="section_1">
		<div class="main_header header" id="myHeader">
			<div class="inner">
			
			<!--menu-->
			<div class="header_section">
			<div class="logo">

			<a href="{{ url('/') }}"><img src="{{ url('/') }}/public/images/logo.png" alt="{{ config('app.name', 'Laravel') }}"></a>
			</div>
			
			<ul class="right_head">
			<li class="statistics">
			<a href="{{ url('coins') }}"><i class="fa fa-globe" aria-hidden="true"></i>Dashboard
			</a>
			</li>
			
			
			
			@guest
            
			<li class="nav-menu">
						<!-- Button trigger modal -->
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
						Login
						</button>

						<!-- Modal -->
						<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog model-pop" role="document">
							<div class="modal-content">
							  <div class="modal-header p-0">
								
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
								
								<div class="logo-popup">
									<a href="index.html"><img src="{{ url('/') }}/public/images/logo-pop.png"></a>
								</div>
							  </div>
							  <div class="model-body">
							  <div class="model-body-content">
									<form method="POST" action="{{ route('login') }} " role="form" class="login-form">
								{{csrf_field()}}
								<div class="form-title col-md-12">
								<p>Welcome back! Sign in to your account to access all masternode.</p></div>
									<div class="form-group col-lg-12">
										<label>E-Mail Address</label>
										<input placeholder="Email" id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
										@if ($errors->has('email'))
											<span class="invalid-feedback">
												<strong>{{ $errors->first('email') }}</strong>
											</span>
										@endif
									</div>
									<div class="form-group col-lg-12">
										<label>Password</label>
										<input placeholder="Password" id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

										@if ($errors->has('password'))
											<span class="invalid-feedback">
												<strong>{{ $errors->first('password') }}</strong>
											</span>
										@endif
									</div>
									<div class="form-group pull-left col-lg-12">
									<div class="form-group pull-left remember-me">
										<input type="checkbox">Remember me
									</div>
									
									<div class="form-group pull-right forgot-pwd">
										<a href="">forgot password</a>
									</div>
									</div>
									
									<div class="form-group btn-sec col-md-12">
									<button type="submit" class="btn ">{{ __('Login') }}</button>
									</div>
								</form>
							 
							  </div>
						  
						  <div class="model-body-content">
								 <form method="POST" action="{{ route('register') }}" role="form"  class="login-form">
					{{csrf_field()}}  
					 <div class="form-title col-md-12"> 
					<p>Create an account today and start using masternode.</p>
					</div>
					<div class="form-group col-md-12">
					<label class="sr-only" for="form-username">Name</label>
					<input placeholder="Name"  id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

					@if ($errors->has('name'))
						<span class="invalid-feedback">
							<strong>{{ $errors->first('name') }}</strong>
						</span>
					@endif
					</div>

					<div class="form-group col-md-12">
					<label class="sr-only" for="form-username">Email</label>
					<input placeholder="Email"  id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

					@if ($errors->has('email'))
					<span class="invalid-feedback">
					<strong>{{ $errors->first('email') }}</strong>
					</span>
					@endif
					</div>

					<div class="form-group col-md-12">
					<label class="sr-only" for="form-password">Password</label>
					<input placeholder="Password"  id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

					@if ($errors->has('password'))
					<span class="invalid-feedback">
					<strong>{{ $errors->first('password') }}</strong>
					</span>
					@endif
					</div>

					<div class="form-group col-md-12">
					<label class="sr-only" for="form-password">Confirm Password</label>
					<input placeholder="Confirm Password" id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
					</div>
					
					<div class="form-group btn-sec col-md-12">
					<button type="submit" class="btn btn-primary">Register</button>
					</div>
				</form>
				
						  </div>
						</div>
						</div>
						
			</li><!--end pop up-->
			
			
                        @else
						
							
						<li class="faq_part">
						<a href="{{ url('/moniter') }}">Build</a>
						</li>	
						 <li class="master_node">	
							<div class="faq_part menu-dropdown">
                                <div class="dropdown">
								  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									My Account
								  </button>
								  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
									<a class="dropdown-item" href="{{ url('/')}}/home" >
                                    {{ Auth::user()->name }}
                                </a>
									<a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{csrf_field()}}  
                                    </form>

									</div>
								</div>
							</div>
						 </li>
							 <!--li class="master_node">
							<div class="faq_part">
                               
                                    <a class="" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{csrf_field()}}  
                                    </form>
                            </div> 
						</li-->							
                        @endguest			

			
			
			<li class="faq_part">
			<a href="{{ url('/') }}/faq"><i class="fa fa-question-circle"></i> FAQ</a>
			</li>
			
			</ul>
		
          </div>
			<!--menu-->
			</div>
			</div>
			</div>
			
		
		
		
     @yield('content')
	 </div>
	 
	
	<!--My account page js-->
   
	<script>
	// When the user scrolls the page, execute myFunction 
window.onscroll = function() {myFunction()};

// Get the header
var header = document.getElementById("myHeader");

// Get the offset position of the navbar
var sticky = header.offsetTop;

// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
  if (window.pageYOffset >= sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}

	</script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="{{ asset('/public/js/placeholders.min.js') }}" ></script>
	<script src="{{ asset('/public/js/bootstrap-brogressbar-manager.min.js') }}" ></script>
	<script src="{{ asset('/public/js/bootstrap.min.js') }}" ></script>
	<script src="{{ asset('/public/js/main.js') }}" ></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	
	<script src="{{ asset('/public/js/sweetalert.js') }}" ></script>	
	<script src="{{ asset('/public/js/medic.js') }}?time=<?php echo time()?>" ></script>	
	<script src="{{ asset('/public/js/index.js') }}"></script>
	<script src="{{ asset('/public/js/jquery.metisMenu.js')}}"></script>
    <!-- Morris Chart Js -->
    <script src="{{ asset('/public/js/index.js')}}"></script>
    <script src="{{ asset('/public/js/morris/raphael-2.1.0.min.js')}}"></script>
    <script src="{{ asset('/public/js/morris/morris.js')}}"></script>
	
	
	<script src="{{ asset('/public/js/easypiechart.js')}}"></script>
	<script src="{{ asset('/public/js/easypiechart-data.js')}}"></script>
	
    <!-- Custom Js -->
    <script src="{{ asset('/public/js/custom-scripts.js')}}"></script>
    <script src="{{ asset('/public/js/portfolio.js')}}"></script>
	
	<div class="loader"style="display:none;"><img class="loaderimg "src="{{ url('/')}}/public/images/loader.gif"/>
	
	</div>
</body>
</html>
