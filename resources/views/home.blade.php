@extends('layouts.layoutpage')

@section('content')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<div class="active-masternode masternode-row">
@include('slider')
	<!-- Top content -->
      <div class="top-content m_hgt">
         <div class="outer-div-sh">
		  <div class="container">
			 <div class="inner-box-sh">
           <div class="toppad" >
		     <div class="about-me" id="about">
					<div class="row">
						<div class="col-md-4 col-xs-12">
							<div class="mydetails slideanim text-center">
							<form id="profileform" enctype="multipart/form-data">
							{{csrf_field()}}
								<div class="page-haeading user-heading">
									<h2 class="text-center">{{$user->name}}</h2>
									<button id="editprofileshow" type="button" class="btn btn-default btn-sm">
								     <i class="far fa-edit"></i> Edit
								    </button>
								</div>
								<input name="name" type="text" id="user_name" class="form-input profile-form" placeholder="Your Name" value="{{$user->name}}"/>
								@if($usermeta->image)
								<img alt="User Pic" src="{{url($usermeta->image)}}" class="img-circle img-responsive"> 
								@else
									<img alt="User Pic" src="http://www.uic.mx/posgrados/files/2018/05/default-user.png" class="img-circle img-responsive"> 
								@endif
								<div class="box form-input profile-form">
								<input type="file" name="image" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple />
								<label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Choose a file&hellip;</span></label>
							</div>
								<!--input name="image" type="file" id="user_image" class=""/-->
								<input type="submit" id="user_form_submit" class="form-input profile-form btn btn-primary card-header-warning" value="Update"/>
								</form>
							</div>
						</div>
						<div class="col-md-8 col-xs-12">
							<div class="myskills slideanim" id="account-detail">
								<div class="skill-info"> 
								   <div class="history-button ad-box-shadow">
									<div class="table-responsive">
									    <h4 class="card-header-primary">{{$user->name}}</h4>
										<table class="table table-user-information">
											<tbody>
												<tr>
													<td><strong>Email:</strong></td>
													<td>{{$user->email}}</td>
													
												</tr>
												<tr>
													<td><strong>Hosting balance:</strong></td>
													<td>{{$usermeta->balance}}</td>
													
													</tr>
													<tr>
													<td><strong>Est Balance Runtime for {{'[ '.$total_mns.' ]'}} MN:</strong></td>
													@if($days > 2)
													<td class="green">
													{{$days}} Day(s)</td>
													 @else
                                                      <td class="red">
													{{$days}} Day(s)</td>
													 @endif

													
													</tr>
												<tr>

										<td><strong>Enable Notifications:</strong></td>
										<td>
										<div class="material-switch pull-right">
											<input @if($user->notification) checked @endif value="true"id="someSwitchOptionDefault" name="someSwitchOption001" type="checkbox"/>
											<label for="someSwitchOptionDefault" class="label-default"></label>
										</div>
									</td>
										
									</tr>	
												
											</tbody>
										</table>
										
									</div>
									</div>
							
                                         <div class="history-button ad-box-shadow">
									      <h4 class="card-header-primary">Deposit</h4>									
									    <div class="col-md-4 user-info-btn button-full">
											<a href="{{url('/charges')}}" class="btn btn-primary" id="credit">SATC</a>
										</div>
										<div class="col-md-4 user-info-btn button-full">
										<a href="{{url('/btc-currency')}}" class="btn btn-primary" id="credit">BTC</a>
										</div>
										<div class="col-md-4 user-info-btn button-full">
										<a href="{{url('/other-currency')}}" class="btn btn-primary" id="credit">Other Currencies</a>
									   </div>
									   <!-- <div class="col-md-4 user-info-btn button-full">
											<a style="float:right;"href="{{url('/withdraw')}}" class="btn btn-primary" id="withdraw">Withdraw Balance</a>
									    </div> -->
									</div>
								
									   <div class="history-button ad-box-shadow">
									      <h4 class="card-header-primary">History</h4>
										 <div class="col-md-6">
										     <a href="{{url('/history/deposit')}}" class="btn btn-primary card-header-warning" id="withdraw">Deposit</a>
										 </div>
										 <div style="text-align:center;"class="col-md-6">
											 <a href="{{url('/history/fees')}}" class="btn btn-primary card-header-danger" id="fees-history">Fees</a>
										 </div>
										 <!--div  class="col-md-4">
											 <a style="float:right;" href="{{url('/history/withdraw')}}" class="btn btn-primary card-header-primary" id="withdraw">Withdraw History</a>
										 </div-->
								      </div>
							  </div>
								
						 </div>


							  <div class="sub-main-w3" id="change-pwd">
								 <form action="#" method="post">
									<h2>Change password
										<i class="fa fa-level-down-alt"></i>
									</h2>
									<div class="form-style-agile">
										<label>
											<i class="fa fa-user"></i>
											Email
										</label>
										<input placeholder="Email" name="Name" type="text" required="">
									</div>
									<div class="form-style-agile">
										<label>
											<i class="fa fa-unlock-alt"></i>
											Old Password
										</label>
										<input placeholder="Old Password" name="Password" type="password" required="">
									</div>
									
									<div class="form-style-agile">
										<label>
											<i class="fa fa-unlock-alt"></i>
											New Password
										</label>
										<input placeholder="New Password" name="Password" type="password" required="">
									</div>

									<input type="submit" value="Change Password">
									
								</form>
								<button id="back">back</button>
							</div>
								 
					 
					 <div class="sub-main-w3" id="change-email">
					<form action="#" method="post">
						<h2>Change Email
						</h2>
						<div class="form-style-agile">
							<label>
								<i class="fa fa-envelope"></i></i>
								Old Email
							</label>
							<input placeholder="Old Password" name="Email" type="text" required="">
						</div>
						
						<div class="form-style-agile">
							<label>
								<i class="fa fa-envelope"></i>
								New Email
							</label>
							<input placeholder="New New" name="Email" type="text" required="">
						</div>

						<input type="submit" value="Change Email">
						
					</form><button id="back2">back</button>
				</div>				
						</div>
			</div>
	</div>	
</div>
   
    
		 
				</div>    
				</div>    
				</div>    
			
				</div>
	
</div>

	
		
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
	<script>

	jQuery('#back').click(function(){
   jQuery('#change-pwd').hide();
    jQuery('#change-email').hide();
    jQuery('#account-detail').show();
})
	jQuery('#back2').click(function(){
   jQuery('#change-pwd').hide();
    jQuery('#change-email').hide();
    jQuery('#account-detail').show();
})
	jQuery('#pwsd').click(function(){
   jQuery('#change-pwd').show();
    jQuery('#change-email').hide();
    jQuery('#account-detail').hide();
})

jQuery('#email').click(function(){
    jQuery('#change-pwd').hide();
    jQuery('#change-email').show();
    jQuery('#account-detail').hide();    
})

jQuery( document ).ready(function() {
    jQuery('#change-pwd').hide();
    jQuery('#change-email').hide();
    jQuery('#account-detail').show();
});


	</script>
	
<?php if($usermeta->balance<=0){?>
	<script>
	jQuery( document ).ready(function() {
   swal({
  type: 'warning',
  title: 'Low Balance',
  text: 'You are running on low balance so Masternode will stopped at anytime',
  footer: '<a href="/charges">Credit Balance</a>'
})
});
</script>
<?php }?>
	@include('layouts.footer')
@endsection
