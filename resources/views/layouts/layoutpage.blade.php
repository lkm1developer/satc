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
     <link rel="stylesheet" href="{{ asset('public/css/swiper.min.css') }}">
	<link rel="stylesheet" href="{{ asset('public/fonts/stylesheet.css') }}">
	<link rel="stylesheet" href="{{ asset('public/css/animate.min.css') }}">
	<link rel="stylesheet" href="{{ asset('public/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<link href="{{ asset('public/css/style.css') }}?time=<?php echo time()?>" rel="stylesheet">
	<link href="{{ asset('public/css/style1.css') }}" rel="stylesheet">
	<link href="{{ asset('public/css/percentageloader.css') }}" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

	<link rel="icon" href="{{ asset('/public/images/logo_fevicon.png')}}" type="image/png">
</head>
<body>

	<div id="wrapper">
	 <!--div class="inner-video opacity-inner">
            <video autoplay="" muted="" loop="" id="myVideo">
				  <source src="http://217.182.138.42/public/images/banner-video.mp4" type="video/mp4" type="video/mp4">
				  	<source src="img/banner-video.ogv" type="video/ogg">
					<source src="img/banner-video.webm" type="video/webm">
				</video>
         </div-->
		<div class="section_1">
		<div class="main_header inner_header header" id="myHeader">
			<div class="inner">
			
			<!--menu-->
			<div class="header_section">
			<nav class="navbar navbar-expand-lg">
			<div class="logo">
			<a href="{{ url('/') }}"><img src="{{ url('/') }}/public/images/logo.png" alt="{{ config('app.name', 'Laravel') }}"></a>
			<a href="{{ url('/') }}"></a>
			</a>
			</div>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fa fa-bars" aria-hidden="true"></i>
  </button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="right_head" style="width:100% !important">
			<li class="statistics ">
			@if(Auth::check())
			<li class="statistics {{ request()->is('coins') ? 'active' : '' }}">
			<a class="{{ request()->is('coins') ? 'active' : '' }}"href="{{ url('/coins') }}"><i class="fa fa-globe" aria-hidden="true"></i>Coins
			</a>
			</li>
			@endif
			
			
			
			@guest
            
						<li class="nav-menu">
						<!-- Button trigger modal -->
						<button id="loginpop"type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
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

							  	<!-- . -->

							  	<!-- . -->
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
					
					@endif
					<div class="alert alert-info">
								  <strong>Info!</strong> The password must have  minimum six characters and contains at least 
									  characters (a – z)<br>
									one digits(0 – 9) and a Non-alphanumeric ( !, $, #, or %)<br>
								</div>
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
						<li class="faq_part {{ request()->is('moniter') ? 'active' : '' }}">
						<a class="{{ request()->is('moniter') ? 'active' : '' }}" href="{{ url('/moniter') }}">Dashboard</i></a>
						</li>
						<li class="master_node nav-item dropdown">
				<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
					<i class="fa fa-bell" aria-hidden="true"></i> <span class="caret"></span>
				</a>

				<div id="notification"class="dropdown-menu dropdown-menu-right " aria-labelledby="navbarDropdown">
				<ul class="ul-notification">
					<?php $user =Auth::user();
					foreach ($user->unreadNotifications as $notification) {
								if( $notification->type=='App\Notifications\Reward'){
									$data= ($notification->data)[0];				
									$url= url('/home/view/'.$data['node']['id']);
									$name= $data['node']['masternode']['name'];
									$amount= $data['APIdata']['last_paid_amount'];
									echo '<li><a class="reward-notification"href="'.$url.'">Masternode '.$data['node']['id'].' '.$name.' rewarded by '.$amount.'</a></li>';
								}
								else if( $notification->type=='App\Notifications\Status'){
									$data= ($notification->data)[0];				
									$url= url('/home/view/'.$data['node']['id']);
									$name= $data['node']['masternode']['name'];
									$status= $data['APIdata']['status'];
									echo '<li><a class="status-notification" href="'.$url.'">Masternode '.$data['node']['id'].' '.$name.' status changed to '.$status.'</a></li>';
								}
								else if( $notification->type=='App\Notifications\Ticketnotification'){
									$data= ($notification->data)[0]; 
									if(array_key_exists('comment',$data)){
									//echo '<pre>';
									//var_dump($data);	die;							
									$url= url('/tickets/'.$data['comment']['ticket_id']);
									$subject= $data['comment']['ticket']['subject'];
									$content= $data['comment']['content'];
									echo '<li><a class="ticker-notification" href="'.$url.'">Ticket  "'.$subject.'" has new comment '.substr($content,0,10).'..</a></li>';
									}
									else if(array_key_exists('ticketStatusUpdated',$data)){
									$url= url('/tickets/'.$data['ticketStatusUpdated']['id']);
									$subject= $data['ticketStatusUpdated']['subject'];
									echo '<li><a class="ticker-notification" href="'.$url.'">Ticket  "'.$subject.'" status has been changed </a></li>';
									}
								}
								
							}
							?>
							</ul>
					<?php //var_dump(count($user->unreadNotifications))?>		
					@if(count($user->unreadNotifications)>0)		
					<a class="dropdown-item" href="{{ route('markasread') }}"
					   onclick="event.preventDefault();
									 document.getElementById('markasread-form').submit();">
						Mark as Read
					</a>

					<form id="markasread-form" action="{{ route('markasread') }}" method="POST" style="display: none;">
						{{csrf_field()}} 
					</form>
					@else
						No New Notifications
					@endif
				</div>
			</li>			
			<li class="master_node nav-item dropdown">
				<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
					{{ Auth::user()->name }} <span class="caret"></span>
				</a>

				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="{{ url('/home') }}">
						Account
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
			</li>
										
                        @endguest
			
			
			
			
			<li class="statistics {{ request()->is('tickets') ? 'active' : '' }}">
			<a class="{{ request()->is('tickets') ? 'active' : '' }}"href="{{ url('/tickets') }}"><i class="fa fa-globe" aria-hidden="true"></i>Support
			</a>
			</li>
			<li class="faq_part {{ request()->is('faq') ? 'active' : '' }}">
			<a class=""href="{{ url('/') }}/faq"><i class="fa fa-question-circle"></i> FAQ</a>
			</li>
			<li class="faq_part {{ request()->is('stats') ? 'active' : '' }}">
			<a class=""href="{{ url('/') }}/stats"><i class="fa fa-question-circle"></i> Stats</a>
			</li>
		
			</ul>
          </div>
          </div>
			<!--menu--> 
			</div>
		</nav>
			
			
		
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
	<script src="{{ asset('public/js/clipboard.js') }}" ></script>	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
	<script src="{{ asset('public/js/placeholders.min.js') }}" ></script>
	<!-- <script src="{{ asset('public/js/bootstrap-brogressbar-manager.min.js') }}" ></script> -->
	<script src="{{ asset('public/js/bootstrap.min.js') }}" ></script>
	<script src="{{ asset('public/js/main.js') }}" ></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>
	
	<script src="{{ asset('public/js/percentageloader.js') }}?time=<?php echo time()?>" ></script>	
	<script src="{{ asset('public/js/progress-bar.js') }}" ></script>	
	<script src="{{ asset('public/js/sweetalert.js') }}" ></script>	
	<script src="{{ asset('public/js/medic.js') }}?time=<?php echo time()?>" ></script>	
	<script src="{{ asset('public/js/lkm.js') }}?time=<?php echo time()?>" ></script>	
	<script src="{{ asset('public/js/convert.js') }}?time=<?php echo time()?>" ></script>	
	<script src="{{ asset('public/js/index.js') }}"></script>
	<script src="{{ asset('public/js/jquery.metisMenu.js')}}"></script>
    <script src="{{ asset('public/js/swiper.min.js') }}"></script>
	<div class="loader"style="display:none;"><img class="loaderimg "src="{{ url('/')}}/public/images/loader.gif"/>
	
	
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
	</div>
	<style>.main_header li.active a {

    color: #ffbd00;

}</style>
     <script>
    var swiper = new Swiper('.swiper-container', {
      spaceBetween: 0,
      centeredSlides: true,
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
  </script>
</body>
</html>
