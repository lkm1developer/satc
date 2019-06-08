@extends('layouts.layoutpage')
@section('content')
<div class="main_my_account join">
   <!-- Top content -->
   <div class="top-content">
      <div class="inner-bg">
         <div class="container">
            <div class="row">
               <div class="col-lg-12 col-md-12 col-sm-12 page-haeading">
                  <h2><strong>Join</strong></h2>
                 
               </div>
            </div>
<!-- . -->
<div class="row">
  <div class="cont_login login-desktop">
     <div class="cont_info_log_sign_up">
        <div class="col_md_login">
           <div class="cont_ba_opcitiy">
              <div class="form-top-left">
                 <h3>Login</h3>
                 <p>Sign in to your account to access all masternode.</p>
              </div>
              <button class="btn_login" onclick="cambiar_login()">LOGIN</button>
           </div>
		   
        </div>
        <div class="col_md_sign_up">
           <div class="cont_ba_opcitiy">
              <div class="form-top-left">
                 <h3>Register</h3>
                 <p>Create an account today and start using masternode.</p>
              </div>
              <button class="btn_sign_up" onclick="cambiar_sign_up()">SIGN UP</button>
           </div>
        </div>
     </div>
     <div class="cont_back_info">
        <div class="cont_img_back_grey">
           <img src="https://images.unsplash.com/42/U7Fc1sy5SCUDIu4tlJY3_NY_by_PhilippHenzler_philmotion.de.jpg?ixlib=rb-0.3.5&q=50&fm=jpg&crop=entropy&s=7686972873678f32efaf2cd79671673d" alt="" />
        </div>
     </div>
     <div class="cont_forms">
        <div class="cont_img_back_">
           <img src="https://images.unsplash.com/42/U7Fc1sy5SCUDIu4tlJY3_NY_by_PhilippHenzler_philmotion.de.jpg?ixlib=rb-0.3.5&q=50&fm=jpg&crop=entropy&s=7686972873678f32efaf2cd79671673d" alt="" />
        </div>
        <div class="cont_form_login">
           <a href="#" onclick="ocultar_login_sign_up()"><i class="fa fa-close"></i></a>
               <div class="form-box form-box1">
                  <div class="form-wrap pull-right">
                     <div class="form-top">
                        <div class="form-top-left">
                           <h3>Login</h3>
                           <p>Welcome back! Sign in to your account to access all masternode.</p>
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
                        <div class="form-top-right">
                          
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
        </div>
        <div class="cont_form_sign_up">
           <a href="#" onclick="ocultar_login_sign_up()"><i class="fa fa-close"></i></a>
               <div class="form-box">
                  <div class="form-wrap">
                     <div class="form-top">
                        <div class="form-top-left">
                           <h3>Register</h3>
                           <p>Create an account today and start using masternode.</p>
						   @if (session('confirmation-success'))
							<div class="alert alert-success">
								{{ session('confirmation-success') }}
							</div>
						@endif
                        </div>
                        <div class="form-top-right">
                         
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
		
		
		
     </div>
  </div>
</div>

<div class="login-mob">
	<div class="cont_form_login" style="display: block; opacity: 1;">
        
               <div class="form-box form-box1">
                  <div class="form-wrap pull-right">
                     <div class="form-top">
                        <div class="form-top-left">
                           <h3>Login</h3>
                           <p>Welcome back! Sign in to your account to access all masternode.</p>
                        </div>
                        <div class="form-top-right">
                          
                        </div>
                     </div>
                     <div class="form-bottom">
                        <form method="POST" action="http://217.182.138.42/login " role="form" class="login-form">
                           <input type="hidden" name="_token" value="vyXROJhUvRT00Pgc3nXhLCPsGFqqyAe6C01cVYwF">
                           <div class="form-group">
                              <label class="sr-only" for="form-username">Seed</label>
                              <input placeholder="Email" id="email" type="email" class="form-control" name="email" value="" required="" autofocus="">
                                                         </div>
                           <div class="form-group">
                              <label class="sr-only" for="form-username">Seed</label>
                              <input placeholder="Password" id="password" type="password" class="form-control" name="password" required="">
                                                         </div>
                           <button type="submit" class="btn ">
                           Login
                           </button>
                        </form>
                     </div>
                  </div>
               </div>
        </div>
		<div class="cont_form_sign_up" style="opacity: 1; display: block;">
        
               <div class="form-box">
                  <div class="form-wrap">
                     <div class="form-top">
                        <div class="form-top-left">
                           <h3>Register</h3>
                           <p>Create an account today and start using masternode.</p>
                        </div>
                        <div class="form-top-right">
                         
                        </div>
                     </div>
                     <div class="form-bottom">
                        <form method="POST" action="http://217.182.138.42/register" role="form" class="login-form">
                           <input type="hidden" name="_token" value="vyXROJhUvRT00Pgc3nXhLCPsGFqqyAe6C01cVYwF">  
                           <div class="form-group">
                              <label class="sr-only" for="form-username">Name</label>
                              <input placeholder="Name" id="name" type="text" class="form-control" name="name" value="" required="" autofocus="">
                                                         </div>
                           <div class="form-group">
                              <label class="sr-only" for="form-username">Email</label>
                              <input placeholder="Email" id="email" type="email" class="form-control" name="email" value="" required="">
                                                         </div>
                           <div class="form-group">
                              <label class="sr-only" for="form-password">Password</label>
                              <input placeholder="Password" id="password" type="password" class="form-control" name="password" required="">
                                                         </div>
                           <div class="form-group">
                              <label class="sr-only" for="form-password">Confirm Password</label>
                              <input placeholder="Confirm Password" id="password-confirm" type="password" class="form-control" name="password_confirmation" required="">
                           </div>
                           <button type="submit" class="btn ">Register</button>
                        </form>
                     </div>
                  </div>
               </div>
        </div>
	
		</div>
         </div>
      </div>
   </div>
</div>

@include('layouts.footer')			
@endsection