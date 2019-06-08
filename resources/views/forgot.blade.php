@extends('layouts.layout')

@section('content')
		<div class="main_head_faq forget-pwd">
  <div class="container">
  <div class="inner-page-title">
        <h2>Forgot Seed</h2>
		<p>Enter your registered email address and check your Email inbox .</p>	
  </div>  
    
 <div class="row">
 <div class="col-md-12 col-sm-12 col-xs-12 margin-bottom">
            <div class="ce-feature-box-38">
              <div class="img-box">
                <div class="bg-circle-box">
                 <a class="img"><img src="{{ url('/') }}/public/images/forget-password.png"alt="" class="img-responsive"></a>
                </div>
              </div>
              <div class="text-box white text-left">
                <h5 class="less-mar-1 title"> Forgot your seed?</h5>
				@if($get==false)
					@if($error==true)
					  <div class="alert alert-danger">
					  <strong>Warning!</strong> User  not Found
					</div>
					@endif
					@if($error==false)
						<div class="alert alert-success">
						  <strong>Success!</strong> Email Sent !!<br>
						  check your Email inbox
						</div>
					@endif
				@endif
                  <form method="POST" action="{{ url('/forgot') }}">
				{{   csrf_field()}}
				
						
							<div class="email email-seed">
							 <input id="email" type="email" class="{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="Seed">
							<span class="icons i1"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
							
							</div>
							@if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
							
									
							<input type="submit" value="Get Seed" name="login">
							
							
				</form>
              </div>
            </div>
			
  </div>

 
  
 
  
  

</div>
</div>

</div>

	
	@include('layouts.footer')
			
	
@endsection