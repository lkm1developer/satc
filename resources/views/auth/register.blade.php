@extends('layouts.layoutpage')

@section('content')
	
<div class="main_my_account m_hgt">
	<!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
					
                        <div class="col-lg-12 col-md-12 col-sm-12 page-haeading">
                            <h2><strong>My</strong>Account</h2>
                            	<p>Lorem ipsum dolor sit amet, felis reprehenderit, malesuada Lorem ipsum dolor sit amet, felis reprehenderit, malesuad
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
							
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 form-box">
                        <div class="form-wrap">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Login</h3>
                            		<p>Login to check your Masternode stataus</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-lock"></i>
                        		</div>
								
                            </div>
                            <div class="form-bottom">
							 <form method="POST" action="{{ route('login') }} " role="form" class="login-form">
									{{csrf_field()}}
			                    
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Seed</label>
			                        	 <input placeholder="Email" id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

										@if ($errors->has('email'))
											<span class="invalid-feedback">
												<strong>{{ $errors->first('email') }}</strong>
											</span>
										@endif
			                        </div>
			                     <div class="form-group">
			                    		<label class="sr-only" for="form-username">Seed</label>
			                        	 <input placeholder="Password" id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

										@if ($errors->has('password'))
											<span class="invalid-feedback">
												<strong>{{ $errors->first('password') }}</strong>
											</span>
										@endif
			                        </div>
			                     <button type="submit" class="btn ">
                                    {{ __('Login') }}
                                </button>
			                        
			                    </form>
		                    </div>
							
							
                        </div>
                        </div>
                    
                   
                        <div class="col-lg-6 col-md-6 col-sm-12 form-box">
                        <div class="form-wrap">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Register</h3>
                            		<p>Register and Launch your masternode in the  few clicks</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-user"></i>
                        		</div>
								
                            </div>
                            <div class="form-bottom">
			                    <form method="POST" action="{{ route('register') }}" role="form"  class="login-form">
								{{csrf_field()}}  
							  
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Name</label>
			                        	<input placeholder="Name"  id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

										@if ($errors->has('name'))
											<span class="invalid-feedback">
												<strong>{{ $errors->first('name') }}</strong>
											</span>
										@endif
			                        </div>
			                       <div class="form-group">
			                    		<label class="sr-only" for="form-username">Email</label>
			                        	<input placeholder="Email"  id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

										@if ($errors->has('email'))
											<span class="invalid-feedback">
												<strong>{{ $errors->first('email') }}</strong>
											</span>
										@endif
			                        </div>
			                        <div class="form-group">
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
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Confirm Password</label>
			                        	 <input placeholder="Confirm Password" id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
			                        </div>
			                       <button type="submit" class="btn ">Register</button>
			                    </form>
		                    </div>
							
							
                        </div>
                        </div>
                  </div>
				  
				 <!--  <div class="social-login">
                        	<h3>...or login with:</h3>
                        	<div class="social-login-buttons">
	                        	<a class="btn btn-link-2" href="#">
	                        		<i class="fa fa-facebook"></i> Facebook
	                        	</a>
	                        	<a class="btn btn-link-2" href="#">
	                        		<i class="fa fa-twitter"></i> Twitter
	                        	</a>
	                        	<a class="btn btn-link-2" href="#">
	                        		<i class="fa fa-google-plus"></i> Google Plus
	                        	</a>
                        	</div>
                        </div> -->
                </div>
            </div>
            
        </div>

</div>
	
	
	
@include('layouts.footer')			
	
@endsection