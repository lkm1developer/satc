@extends('layouts.layoutpage')
@section('title', 'Buy Credits')
@section('content')
 <div class="container">
 <div class="transaction-page m_hgt">
			<div class="page-haeading">
                    <h2>{{$coin->name}} Masternode<strong> Setup</h2>
				</div>
               
 <div class="row c-card u-p-small u-mb-large">
	 <div class="form-main-class">
		 <div class="form-inner">
                                 
			 <div class="col-lg-12">
				 <div class="row">
                    <div class="masternode-wallet col-lg-12 p-0">
							<div class="wallet-content">
								<div class="transaction-content-detail">
									<h6>Open the Debug console</h6>
									<p>Open debug console from the top menu Help -> Debug window -> Console. </p>
								</div>

									<div class="transaction-content-detail""
										<h6>In the Debug console type <b> "getnewaddress" insert your masternode name here</b> then hit Enter </h6>
										<p>We will call the output of this command "collateral address". This will hold the funds that enable you to start the masternode. Also, note that this address is your own, as it was generated in your wallet. </p>
									</div>

									<div class="transaction-content-detail">
										<h6>On the "Send" tab of your wallet</h6>
										<p>Send exactly {{$coin->minbal}} {{$coin->name}} (no more, no less) to the collateral address you just generated. Make sure that "Subtract fee from amount" is NOT checked. </p>                  
									</div>
							</div>
												
					 
						<div class="c-field u-mb-small has-icon-right wallet-sec">
						<label class="c-field__label wallet-id" for="input6">After sending the payment, Enter the transaction ID below.</label>
						<form id="verify_tranx"method="post"enctype = 'multipart/form-data'action="{{url('/tranxaction')}}/{{$coin->id}}">
                            <input type="hidden" name="_token" id="csrf-token" value="{{csrf_token()}}" />
							<input type="hidden" name="coin" id="coinname" value="{{$coin->id}}" />
							<input name="txid"class="c-input c-input--success" id="input6" type="text" value="" placeholder="Transaction ID">
							<span class="c-field__icon">
								<i class="fa fa-check u-color-success"></i>
							</span>
							
							 <div class="col u-mb-medium col-lg-12 transaction-btn p-0">
                                        <!--<a class="c-btn c-btn--success" href="#">Verify Transaction</a>-->
                                         <input type="submit" class="c-btn c-btn--success" style="margin-left: 15px;" value="Verify Transaction">

							</div>
						</form>
						</div>
					</div>
				 </div>
			 </div>
		</div>
				
						
			
	<div class="hasminbal">                
		<div class="row col u-mb-medium col-lg-12 transaction-btn credit-master p-0">				
			<!-- ngIf: ctrl.expired().length -->
			<div class="masternode-row satoshi-masternode">
			<button type="button" class="btn btn-primary progress-btn trans-masternode-btn  btn-info btn-lg" data-toggle="modal" data-target="#myModal" id="triggerclick" style="display:none">Create Masternode</button>
			@if($success||$masternode)
				<input type="hidden"class="triggerclick"/>
			
			@endif
			<!-- Modal -->
			<div id="myModal" class="modal fade " role="dialog">
			  <div class="modal-dialog create-master-pop">
				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">					
					@if ($success)
                                <div class="c-alert c-alert--info">
                                <i class="c-alert__icon fa fa-check-circle">{{$success}}</i> 
                                </div>          
								@endif 
								@if($errors->any())
									 <div class="c-alert c-alert--danger">
										<i class="c-alert__icon fa fa-check-circle"></i> {{$errors->first()}}
									</div>    
					@endif
				  </div>
				 <!-- <div class="modal-body">-->
					@if($masternode)
					@if($masternode->cando==true)
					<div class="c-alert c-alert--info">
                                <i class="c-alert__icon fa fa-check-circle">Masternode setup Progress</i><br> Click Next to continue</br> 
                                </div> 
					<!-- <div class="loader"><img src="{{ asset('public/images/loader.gif') }}"/></div>		
                     <div class="prgrs"style="margin:0px;">
					<!-- <div id="prgrsbar"class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="{{($masternode->step==null)?'20':($masternode->step*20) }}%"aria-valuemin="0" aria-valuemax="100" style="width:
						{{($masternode->step==null)?'20':($masternode->step*20) }}%">
											<span class="prcnt">{{($masternode->step==null)?'20':($masternode->step*20) }}%</span>
						</div>
						</div> >-->
						<!--<div id="myProgressdiv"></div> >-->
                   
					@endif
					@endif
				 <!-- </div>	-->			  
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                   <button type="button" class="btn btn-secondary "  id="launchmasternodenow">Next</button>
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
</div>
</div>
</div>

                                       


</main>
<style>

#myProgressdiv {
    margin: 16px 0;
    padding: 20px 0px;
}
</style>

@include('layouts.footer')
@endsection        