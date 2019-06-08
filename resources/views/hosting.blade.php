@extends('layouts.layoutpage')
@section('title', 'Buy Credits')
@section('content')

 <div class="transaction-page hosting-charge m_hgt">
	@include('slider')
		<div class="outer-div-sh">
		  <div class="container">
			 <div class="inner-box-sh">
               <form class="charge-hosting" method="post"enctype = 'multipart/form-data'action="{{url('/')}}/charges">
                                <input type="hidden" name="_token" id="csrf-token" value="{{csrf_token()}}" />
                             <div class="row c-card u-p-small u-mb-large">
                             <div class="form-main-class">
                             <div class="form-inner">
                                @if ($success)
									<div class="alert alert-success">
								  <strong>Success!</strong> {{$success}}
									</div>                                       
                                    @endif 
                                    @if($errors->any())
										<div class="alert alert-warning">
										  <strong>Warning!</strong> {{$errors->first()}}
										</div>
                                          
                                    @endif 
                                     <div class="col-lg-12">
                                     <div class="row">
                                           

                     
                    <div class="masternode-wallet col-lg-12">
						<div class="c-field u-mb-small">
						<H6 class="c-field__label" style="color:white;" for="companyName">To Launch Masternode simply send SATC to your platform address below  :</H6>  <br>
					   <H6 class="c-field__label" for="companyName"id="copy-target">{{trim($user->satoshi_address)}}</H6> 
					<span class="copy-button fa fa-copy" data-clipboard-action="copy" 
					data-clipboard-target="#copy-target">Copy</span>
				

					   
					   <?php $Setting =  App\Setting::find(1);
							?>
					   <label class="c-field__label" style="color:white;" for="input6">Daily Masternode hosting charge is $0{{$Setting->hosting_rate}} charged in SATC ({{$Setting->rate}} SATC)  </label>
						</div>      
												
					 
						<div class="host-charge-sec">
						<div class="c-field u-mb-small has-icon-right">
						<label class="c-field__label" for="input6">After sending the payment, Enter the transaction ID below.</label>
							<input name="txid"class="c-input c-input--success" id="input6" type="text" value="" placeholder="Transaction ID">
							<span class="c-field__icon">
								<i class="fa fa-check u-color-success"></i>
							</span>
						</div>
						<!--<div class="c-field u-mb-small has-icon-right payer-add">
						<label class="c-field__label" for="input6">Payer Address</label>
							<input name="payer"class="c-input c-input--success" id="input6" type="text" value="" placeholder="Your /Payer Address">
							<span class="c-field__icon">
								<i class="fa fa-check u-color-success"></i>
							</span>
						</div>-->
						
					
					  <div class="col u-mb-medium col-lg-12 transaction-btn p-0">
                                        <!--<a class="c-btn c-btn--success" href="#">Verify Transaction</a>-->
                                         <input type="submit" class="c-btn c-btn--success" style="margin-left: 15px;" value="Verify Transaction">
                        </div></div></div>
				
                    </div>
									 </div>

								
						</div>
						
						</div></div></form>
						
			 </div>
		</div>
	</div>
</div>

                                       


</main>
<style>
#myBar {
    width: 0%;
    height: 30px;
    background-color: #4CAF50;
    text-align: center; /* To center it horizontally (if you want) */
    line-height: 30px; /* To center it vertically */
    color: white;
}

</style>
<style>
	.copy-button.fa.fa-copy {
				color: white;
		}
		.ENABLED{color:green;}
		.inactive{color:red;}
	</style>
<?php if($success){?>
	<script>
	
   swal({
  type: 'success',
  title: 'Payment Completed',
  text: '<?php echo $success;?>'
 

});
</script>
<?php }?>
@include('layouts.footer')
@endsection        