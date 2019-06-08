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
    <script src="{{ asset('/js/app.js') }}" defer></script>   
	<link rel="stylesheet" href="{{ asset('/public/fonts/stylesheet.css') }}">
	<link rel="stylesheet" href="{{ asset('/public/css/animate.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/public/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/public/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="{{ asset('/public/css/style.css').'?itme='.time() }}" rel="stylesheet">
	<link href="{{ asset('/public/css/form-elements.css') }}" rel="stylesheet">
	<link rel="icon" href="{{ asset('/public/images/logo_fevicon.png')}}" type="image/png">
</head>
<body>
<!-- 	<layout.blade.php> -->
	<div id="wrapper">	
	   <div class="inner-video">
            <video autoplay="" muted="" loop="" id="myVideo">
				  <source src="http://217.182.138.42/public/images/banner-video.mp4" type="video/mp4" type="video/mp4">
				  	<source src="img/banner-video.ogv" type="video/ogg">
					<source src="img/banner-video.webm" type="video/webm">
				</video>
         </div>
		<div class="section_1 header_home">
				
		<div class="main_header header" id="myHeader">
			<div class="inner">
			
			<!--menu-->
			<div class="header_section">
			<nav class="navbar navbar-expand-lg">
			<div class="logo">
			<a href="{{ url('/') }}"><img src="{{ url('/') }}/public/images/logo.png" alt="{{ config('app.name', 'Laravel') }}"></a>
			<a href="{{ url('/') }}"></a>
			</a>
			</div>
			<!--button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fa fa-bars" aria-hidden="true"></i>
  </button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="right_head" style="width:100% !important">
			<li class="statistics">
			<a href="{{ url('/coins') }}"><i class="fa fa-globe" aria-hidden="true"></i>Dashboard
			</a>
			</li>
			
			
			
			@guest
            
						<li class="nav-menu">
						<!-- Button trigger modal --
						<button id="loginpop"type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
						Login
						</button>

						<!-- Modal --
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
							  @if (session('confirmation-success'))
									<div class="alert alert-success">
										{{ session('confirmation-success') }}
									</div>
								@endif
								@if (session('confirmation-danger'))
									<div class="alert alert-danger">
										{!! session('confirmation-danger') !!}
									</div>
								@endif
							  <div class="model-body">
							  <div class="model-body-content">

							

							  	<!-- . --
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
										<a href="{{url('/password/reset')}}">forgot password</a>
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
					<div class="alert alert-info">
								  <strong>Info!</strong> The password contains characters from at least three of the following five categories:<br>
									English uppercase characters (A – Z)<br>
									English lowercase characters (a – z)<br>
									Base 10 digits (0 – 9)<br>
									Non-alphanumeric (For example: !, $, #, or %)<br>
								</div>
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
						
			</li><!--end pop up--	
			
                        @else
						<li class="faq_part">
						<a href="{{ url('/moniter') }}">Build</i></a>
						</li>
						<li class="master_node">	
							<div class="faq_part">
                                <a class="" href="{{ url('/')}}/home" >
                                    {{ Auth::user()->name }}
                                </a>
							</div>
							</li>
							 <li class="master_node">
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
						</li>							
                        @endguest
			
			
			
			
			
			<li class="faq_part">
			<a href="{{ url('/') }}/faq"><i class="fa fa-question-circle"></i> FAQ</a>
			</li>
		
			</ul>
          </div>
          </div>
			<!--menu--
			</div-->
		</nav>
		</div>
		</div>
		</div>
		</div>
		</div>
     @yield('content')
	 
	 
	
	<!--sticky header js-->
   
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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="/assets/js/jquery-1.11.1.min.js"></script>
	<!--My account page js-->
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/js/jquery.backstretch.min.js"></script>
    <script src="/assets/js/scripts.js"></script>
	 <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->
		
	<!--Bootsrap 4 js-->
	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
	<script src="{{ asset('/public/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('/public/js/placeholders.min.js') }}" ></script>
	<script src="{{ asset('/public/js/main.js') }}" ></script>
	<script src="{{ asset('/public/js/medic.js') }}" ></script>
	@if  (!$errors->isEmpty()) 
		<script>
	$(document).ready(function(){
		$("#loginpop")[0].click();
		
	});
	</script>
	@endif 
	@if (session('confirmation-success'))
		 <script>
	$(document).ready(function(){
		$("#loginpop")[0].click();
		
	});
	</script>
	@endif
	 @if (session('confirmation-danger'))
		 <script>
	$(document).ready(function(){
		$("#loginpop")[0].click();
		
	});
	</script>
	@endif
</body>
</html>
