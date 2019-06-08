<!DOCTYPE html>
<html><head>
<html lang="{{ app()->getLocale() }}">
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

<link rel="shortcut icon" type="{{ asset('public/new/image/x-icon') }}" href="">
<link rel="stylesheet" href="{{ asset('public/new/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('public/new/css/font-awesome.css') }}">
<link rel="stylesheet" href="{{ asset('public/new/css/ionicons.css') }}">
<link rel="stylesheet" href="{{ asset('public/new/css/AdminLTE.css') }}">
<link rel="stylesheet" href="{{ asset('public/new/css/skin-blue.css') }}">
<link rel="stylesheet" href="{{ asset('public/new/css/pace.css') }}">
<link href="{{ asset('public/new/css/app.css') }}" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body class="skin-blue sidebar-mini    pace-done">
	<div class="pace  pace-inactive">
		<div class="pace-progress" style="transform: translate3d(100%, 0px, 0px);" data-progress-text="100%" data-progress="99">
		  <div class="pace-progress-inner">
		  </div>
		</div>
		<div class="pace-activity"></div>
	</div>
<div id="app">
	<div class="wrapper">
		<header class="main-header">
		<span class="logo-mini">
			<a href="{{url('/')}}">
				<img src="img/copilot-logo-white.svg" alt="Logo" class="img-responsive center-block logo"></a>
				</span> 
				
				<nav role="navigation" class="navbar navbar-static-top"><a href="javascript:;" data-toggle="offcanvas" role="button" class="sidebar-toggle"><span class="sr-only">Toggle navigation</span></a> <div class="navbar-custom-menu"><ul class="nav navbar-nav"><li class="dropdown messages-menu"><a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle"><i class="fa fa-envelope-o"></i> <span class="label label-success">1</span></a> <ul class="dropdown-menu"><li class="header">You have 1 message(s)</li> <li><ul class="menu"><li><a href="javascript:;"><h4>
                          Support Team
                          <small><i class="fa fa-clock-o"></i> 5 mins</small></h4> <p>Why not consider this a test message?</p></a></li></ul></li> <li class="footer"><a href="javascript:;">See All Messages</a></li></ul></li> <li class="dropdown notifications-menu"><a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle"><i class="fa fa-bell-o"></i> <span class="label label-warning">0</span></a> <ul class="dropdown-menu"><li class="header">You have 0 notification(s)</li> <!----> <!----></ul></li> <li class="dropdown tasks-menu"><a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle"><i class="fa fa-flag-o"></i> <span class="label label-danger">0 </span></a> <ul class="dropdown-menu"><li class="header">You have 0 task(s)</li> <!----> <!----></ul></li>
						  <li class="dropdown user user-menu"><a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle"><img src="/128.jpg" alt="" class="user-image"> <span class="hidden-xs">{{ Auth::user()->name }}</span></a></li>
						  
						  </ul>
					  </div>
				  </nav>
	  </header>
	  @include('layouts.leftsidebar')
	 
		
		@yield('content')
	<footer class="main-footer">
    </footer></div></div>
	
	<script async="" src="{{ asset('public/new/js/analytics.js') }}"></script>
	<script src="{{ asset('public/new/js/jQuery-2.js') }}"></script>
	<script src="{{ asset('public/new/js/bootstrap.js') }}"></script>
	<script src="{{ asset('public/new/js/app.js') }}"></script>
	<script src="{{ asset('public/new/js/pace.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/new/js/manifest.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/new/js/vendor.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/new/js/app_002.js') }}"></script>
	</body></html>