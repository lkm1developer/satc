@extends('layouts.layoutpage')

@section('content')
<style>
@media screen and (max-width: 991px){
.reset-pswd form {
    MAX-WIDTH: 100% !IMPORTANT;
}
}
</style>

    <div class="row justify-content-center join  reset-pswd" style="padding-bottom:0 !important;">
	<div class="container">
	 <div class="page-haeading"><h2>Reset Password</h2></div>
        <div class="col-md-12">
               

                <div class="rest-pswd-link" style="margin-bottom:60px;">
                    <form method="POST" action="{{ route('password.request') }}" style=" background: #fff;
    width: 100%;
    max-width: 50%;
    margin: 0 auto;
    padding: 20px;">
                       

                        {{csrf_field()}}
					<input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                            <label for="email" class="col-form-label">{{ __('E-Mail Address') }}</label>

                            <div class="form-row">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-form-label">{{ __('Password') }}</label>

                            
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-form-label">{{ __('Confirm Password') }}</label>

                            
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                           
                        </div>

                        <div class="form-group">
                            
                                <button type="submit" class="btn btn-primary" style="background: #000;
    margin-top: 18px;
    border: 2px solid #000;
    color: #fff;
    height: auto;
    text-align: center;
    font-size: 16px;
    padding: 9px 30px;
    width: 100%;     white-space: normal;">
                                    {{ __('Reset Password') }}
                                </button>
                            
                        </div>
                    </form>
                </div>
           
        </div>
    </div>
</div>
@include('layouts.footer')
@endsection
