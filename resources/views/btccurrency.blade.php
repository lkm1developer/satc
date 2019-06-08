@extends('layouts.layoutpage')
@section('title', 'Buy Credits')
@section('content')
<div class="view-page m_hgt  coin-page">
	@include('slider')
	<div class="outer-div-sh">	
		<div class="container">	
			<div class="inner-box-sh">	
				 <div class="transaction-page hosting-charge m_hgt inner-box-shh">
					<form method="post"enctype = 'multipart/form-data'action="{{url('/')}}/btc-currency">
					<input type="hidden" name="_token" id="csrf-token" value="{{csrf_token()}}" />
					<div class="row c-card u-p-small u-mb-large">
						<div class="form-main-class">
							<div class="form-inner">
							@if(Session::has('message'))
							<p class="alert alert-info">{{ Session::get('message') }}</p>
							@endif
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
								<div class="trans-inner">
									<div class="row"> 
										<div class="col-lg-8">
										   <div class="ad-box-shadow">
											<div class="masternode-wallet">
												<div class="c-field u-mb-small">
													<H6 class="c-field__label" style="color:white;" for="companyName">
														To top up your SATC balance simply send BTC to address below  :
													</H6>  <br>
												<!--	<div class="form-group">
														<label for="sel1">Select Method:</label>
															<select name="payment_method" autocomplete="off" id="methodChanged" class="form-control" id="sel1">
															@foreach($coins as $coin)
																<option id="methodChanged"  value="{{$coin->py_name}}">{{$coin->py_name}}</option>
															@endforeach
															</select>
													</div> -->
													<?php $Setting =  App\Setting::find(1);	?>
													<label class="c-field__label" style="color:white;" for="input6">
														Daily Masternode hosting charge is $0{{$Setting->hosting_rate}} charged in SATC ({{$Setting->rate}} SATC) 
													</label>
													
																				
													
													
													@foreach($coins as $key=>$coin)
														<div style="display:{{$key==0?'block':'none'}};"id="{{$coin->py_name}}-div" class="address_div">
															<H6 id="copy-target{{$coin->py_name}}"class="c-field__label  {{$coin->py_name}}-address" >
																@if($coin->py_name=='SATC')
																{{trim($user->satoshi_address)}}
																@else 
																	<?php
																$add=json_decode($user->coins_address,true);
																if (is_array($add)){
																		if(array_key_exists($coin->py_name,$add)){
																			echo trim($add[$coin->py_name]);
																			
																		}
																	}
																	?>
																	
																@endif
															</H6>
															<input type="hidden" id="ticker-price{{$coin->py_name}}" value="{{$coin->ticker_data??'1'}}"/>
															<!--<span class="copy-button fa fa-copy" data-clipboard-action="copy" data-clipboard-target="#copy-target{{$coin->py_name}}">Copy</span> -->
														</div>	
													@endforeach
													
													<input autocomplete="off" name="satc_price" type="hidden" id="one-satc" value="{{$satc_price}}"/>
													<input autocomplete="off" type="hidden" id="selected_coin" value="{{$coins[0]->py_name}} "/>
													
												</div>  
												<div class="host-charge-sec">
													<div class="c-field u-mb-small has-icon-right">
														<label class="c-field__label" for="input6">
															After sending the payment, Enter the transaction ID below.
														</label>
														<input name="txid"class="c-input c-input--success" id="input6" type="text" value="" autocomplete="off" placeholder="Transaction ID">
														<span class="c-field__icon">
															<i class="fa fa-check u-color-success"></i>
														</span>
													</div>
													<div class="col u-mb-medium col-lg-12 transaction-btn p-0">
														 <input type="submit" class="c-btn c-btn--success" style="margin-left: 15px;" value="Verify Transaction">
													</div>
												</div>
												</form>
												
												<div class="smart-box">
														  <p>
															 <label><span id="last_oc"> {{$coins[0]->py_name}} </span></label>
															<input autocomplete="off" value="{{ $final_oc_price ? $final_oc_price : '' }}"  type="text" readonly>
															</p>
															<p>
															<label>SATC</label><input autocomplete="off" value="{{ $final_satc_price ? $final_satc_price : '' }}"  type="text" readonly>
															</p>
															<form action="{{url('/')}}/addbalancebtc" method="POST">
															
						<input type="hidden" name="_token" id="csrf-token" value="{{csrf_token()}}" />
																<input name="last_oc_value" autocomplete="off" type='hidden' value="{{$final_oc_price}}"/>
																<input name="last_satc_value" autocomplete="off" type='hidden' value="{{$final_satc_price}}"/>
																<input name="curren_coin" autocomplete="off" type='hidden' value="{{$coins[0]->py_name}}"/>
															<input type="submit" value="Add to Balance" class="c-btn c-btn--success" ></form>
													</div>
											</div>
											</div>
										</div>
										<div class="col-lg-4">
										<div class="ad-box-shadow">
										   <div class="masternode-wallet">
											 <h3 class="curren">Currencies Calculator</h3>
										       <div class="other-coins" >
														Type SATC amount 
														<input name="satc-amount" autocomplete="off" value="0" id="satc-amountbtc"type='text'  />
														<div class="lkm_error"></div>
														Converted <span id="other-coins-name"> {{$coins[0]->py_name}} </span> (+20% admin fee)
														<input autocomplete="off" id="converted-smartnode" disabled="disabled"   value="0"/>
														<input name="converted" autocomplete="off" id="converted-smartnode-hidden" type='hidden'   value="0"/>
												</div>
										    </div>
										</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					</form>
				</div>
         </div>

      </div>
</div>

</div>
</div>

					   


</main>



@include('layouts.footer')
@endsection        