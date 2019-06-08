@extends('layouts.layoutpage')
@section('title', 'Withdraw')
@section('content')
<div class="view-page m_hgt">
@include('slider')
		<div class=" wallet-address page_tp">
			<div class="outer-div-sh">
		  <div class="container">
			 <div class="inner-box-sh">
				<div class="row">
				<div class="page-haeading">
					<h2>Wallet <strong>Address</strong></h2>
				</div>
				<div class="col-lg-12">
				<div class="masternode-wallet">	
					@if($user->hostingbalance>0)	
						<div class="c-field u-mb-small">
							<h6 class="c-field__label" for="companyName">
								Transfer your Satoshicoin to your local address 
							</h6>   
							<div class="error-div">
							<span for="companyName">
							Payee Address {{trim($user->satoshi_address)}}
							</span> 	</div>				   
							<label class="c-field__label" for="input6">Your Satoshicoin Wallet address .</label>
						</div> 						
					 <form method="post"enctype = 'multipart/form-data'action="{{url('/')}}/charges">
                                <input type="hidden" name="_token" id="csrf-token" value="{{csrf_token()}}" />
                                <input type="text" id="rev_address" value="" placeholder="Your Satoshicoin Address"/>
								<input type="text" id="amount_coin" value="" placeholder="Coins Amount"/>					
					</form>	
						<div class="create_master_btn">
							<button id="withdrawbalanceb"class="c-btn c-btn--success"  >Withdraw</button>
						</div>
					
				@else
					<div class="c-field u-mb-small">
							<h6 class="c-field__label" for="companyName">
								You Have not suffiecient coin balance to Transfer your Satoshicoin to your local address 
							</h6>
					</div> 	
				@endif
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