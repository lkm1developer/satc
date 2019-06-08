@extends('layouts.layoutpage')

@section('content')
<style>
@media screen and (max-width: 991px){
.reset-pswd form {
    MAX-WIDTH: 100% !IMPORTANT;
}
}
</style>
<div class="main_my_account join  reset-pswd" style="padding-bottom:0 !important;">
   <!-- Top content -->
   <div class="top-content">
      <div class="inner-bg">
         <div class="container">
            <div class="row">
               <div class="col-lg-12 col-md-12 col-sm-12">
               <div class="page-haeading" style="margin-bottom:10px;">
               <h2><strong>Reset Password</strong></h2>
			   <p>Please Enter your Email Address and we will send you a link to reset password</p>
				</div>
				
                <div class="card-body" style="margin-bottom:50px;">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" style=" background: #fff;
    width: 100%;
    max-width: 50%;
    margin: 0 auto;
    padding: 20px;">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="email" class="col-form-label" style=" color: #000;
    font-weight: 600;
    font-size: 18px;
    text-align: center;
    width: 100%;
    margin-bottom: 9px;">{{ __('Enter Your Registered E-Mail Address') }}</label>

                            <div class="form-row">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                       
                            <div class="reset-pswd-btn">
                                <button type="submit" class="btn btn-primary"  style="background: #000;
    margin-top: 18px;
    border: 2px solid #000;
    color: #fff;
    height: auto;
    text-align: center;
    font-size: 16px;
    padding: 9px 30px;
    width: 100%;     white-space: normal;">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
							 
							 
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@include('layouts.footer')
@endsection
