@extends('layouts.layoutpage')
@section('content')
<?php $PC = new App\Http\Controllers\ProfileController; ?>
		 
		<!---View detail page-->
		<div class="view-page m_hgt  coin-page">
		@include('slider')
		<div class="outer-div-sh">
		  <div class="container">
			 <div class="inner-box-sh">
				<div class="page-haeading">
                    <h2><strong>All</strong> Coins</h2>
                    <p>The platform enables everyone to launch a masternode without linux or programming knowledge. Below you can find a list of supported blockchains, more coins will be added in the near future.
					</p>
				</div>
			<!-- Search form -->
			<div class="search-section">
			<div class="col-md-8"></div>
			<div class="col-md-4 col-xs-12 floatright">
			<input id="coinsearch"class="form-control " autocomplete="off" type="text" placeholder="Search" aria-label="Search">	
			</div>
			</div>
			<section id="team">
				<div class="container">
					<div class="row ">
						@foreach($firstFives as $key=>$mn_data)
						<div id="{{strtolower($mn_data['name'])}}"class="col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-2 coindivs">
							<div class="coin-box">
								<div class="image-flip" ontouchstart="this.classList.toggle('hover');">
									<div class="mainflip">
									@if($mn_data['kyd'])
									<a class="coinkyd"href="{{$mn_data['kyd']}}"target="_blank"><img class="coinkydimg"src="{{ url('/public/images/auth.png')}}"></a>
									@endif
										<div class="frontside">
											<div class="card">
												<div class="card-body text-center">
												  <div class="cion-img-left">
												    <a href=""><img src="{{ url('/') }}/public{{$mn_data['logo']}}"></a>

													<h2>{{$mn_data['name']}}</h2>
												  </div>
												  <div class="cion-text-right">
												      <ul>
														 <li>Collateral: <span>{{ @$mn_data['mn_data']['required_coins_for_masternode']}} {{ @$mn_data['mn_data']['coin_ticker']}}</span></li> 
														 <li>Total <span>{{ @$mn_data['mn_data']['active_masternodes']}}</span></li>
														 <li>ROI: <span>{{ @$mn_data['mn_data']['roi_percent']}} % /{{ @$mn_data['mn_data']['roi_days']}} days</span></li>
														 <li>Average Rewards: <span>{{ @$mn_data['mn_data']['daily_income_coins']}} {{@$mn_data['mn_data']['coin_ticker']  }}</span> </li>
														 <li>{{$mn_data['masternode']}} Price: <span>${{ @round(($mn_data['mn_data']['masternode_worth_usd']),5)}}</span></li>
														 <li>Price: <span>${{ @round(($mn_data['mn_data']['price_usd']),5)}}</span></li>
														 <li>Hosted {{$mn_data['masternode']}}:<span> {{$mn_data['getAllRunningMns']}}</span></li>
			                                             @if($PC->GetDesiredIP($mn_data['py_name'],true) > 2)
														 <li>Available IPs : <span class="avail_green"> {{$PC->GetDesiredIP($mn_data['py_name'],true)}}</span></li>	
														 @else
														  <li>Available IPs : <span class="avail_red"> {{$PC->GetDesiredIP($mn_data['py_name'],true)}}</span></li> </ul>
														  @endif
														 
													  </ul>
												  </div>
												</div>
											</div>
										</div>
										<div class="backside">
											<div class="cion-img-left">
										      <a href=""><img src="{{ url('/') }}/public{{$mn_data['logo']}}"></a>
											  <h2>{{$mn_data['name']}}</h2>
										    </div>
										    <div class="satoshi-btn">
											      <a href="{{$mn_data['explorer_link']}}" target="_blank">Explorer</a>
											    <a href="{{$mn_data['website']}}" target="_blank">Website</a>
											    <a href="{{ $mn_data['bitcoin_talk']}}" target="_blank">Bitcion Talk</a>
												<a href="{{$mn_data['github'] }}" target="_blank">GitHub</a>
												<a href="{{ $mn_data['discord']}}" target="_blank">Discord</a>
												<a href="{{ $mn_data['twitter'] }}" target="_blank">Twitter</a>
												@if($mn_data['mno'])
												<a class="coinkydmno"href="{{$mn_data['mno']}}"target="_blank"><img class="coinkydimgmno"src="{{ url('/public/images/mno.png')}}"></a>
												@endif
												@if($mn_data['active'])
										   	<div class="build-button"><a href="{{ url('/moniter') }}/{{$mn_data['id']}}" >Build</a></div>
												@else
												<div class="build-button"><a href="javascript:void(0)">Comming soon</a></div>
												@endif
											</div>
										</div>
									</div>
							   </div>
							</div>
						</div>
						@endforeach
						
						<!-----bottom-content-------------->
						 @foreach($Rests as $key=>$mn_data)
						<div id="{{strtolower($mn_data['name'])}}"class="fullstrip coindivs">
						    <div class="row">
									<div class="col-md-5">
									  <div class="cion-text-right">
										  <ul>
												<li>Collateral: <span>{{ @$mn_data['mn_data']['required_coins_for_masternode']}} {{ @$mn_data['mn_data']['coin_ticker']}}</span></li> 
												<li>Total <span>{{ @$mn_data['mn_data']['active_masternodes']}}</span></li>
												<li>ROI: <span>{{ @$mn_data['mn_data']['roi_percent']}} % /{{ @$mn_data['mn_data']['roi_days']}} days</span></li>
												<li>Average Rewards: <span>{{ @$mn_data['mn_data']['daily_income_coins']}} {{@$mn_data['mn_data']['coin_ticker']  }}</span> </li>
												<li>{{$mn_data['masternode']}} Price: <span>${{ @round(($mn_data['mn_data']['masternode_worth_usd']),5)}}</span></li>
												<li>Price: <span>${{ @round($mn_data['mn_data']['price_usd'],5)}}</span></li>
											 <li>Hosted {{$mn_data['masternode']}}:<span> {{$mn_data['getAllRunningMns']}}</span></li>
											 @if($PC->GetDesiredIP($mn_data['py_name'],true) > 2)
											 <li>Available IPs : <span class="avail_green"> {{$PC->GetDesiredIP($mn_data['py_name'],true)}}</span></li>	
											 @else:
											  <li>Available IPs : <span class="avail_red"> {{$PC->GetDesiredIP($mn_data['py_name'],true)}}</span></li> </ul>
											 @endif
									 </div>	    
									</div>
									<div class="col-md-2">
									@if($mn_data['kyd'])
									<a class="coinkydmd2" href="{{$mn_data['kyd']}}" target="_blank"><img class="coinkydimgmd2"src="{{ url('/public/images/auth.png')}}"></a>
									@endif
									
									  <div class="cion-img-left">
										 <a href="">
										 @if($mn_data['logo'])
										 <img src="/public/{{$mn_data['logo'] }}">
									 @endif
									 </a>
										 <h2>{{$mn_data['name'] }}</h2>
									  </div>
									</div>
									
								 <div class="col-md-5">
                                     <div class="satoshi-btn">
									     <a href="{{$mn_data['explorer_link']}}" target="_blank">Explorer</a>
							             <a href="{{$mn_data['website']}}" target="_blank">Website</a>
											    <a href="{{ $mn_data['bitcoin_talk']}}" target="_blank">Bitcoin Talk</a>
												<a href="{{$mn_data['github'] }}" target="_blank">GitHub</a>
												<a href="{{ $mn_data['discord']}}" target="_blank">Discord</a>
												<a href="{{ $mn_data['twitter'] }}" target="_blank">Twitter</a>
												@if($mn_data['mno'])
												<a class="coinkydmno"href="{{$mn_data['mno']}}"target="_blank"><img class="coinkydimgmno"src="{{ url('/public/images/mno.png')}}"></a>
												@endif
												@if($mn_data['active'])
												
													<div class="build-button"><a href="{{ url('/moniter') }}/{{$mn_data['id']}}" >Build</a></div>
												@else
												<div class="build-button"><a href="javascript:void(0)">Comming soon</a></div>
												@endif
                                      </div>
								 </div>
							</div>
						</div>
						
						@endforeach
						
					</div>
				</div>
            </section>
		</div>
		</div>
		</div>
	</div>
		

		<!---End View detail page-->
					<script>
	$(document).ready(function() {
    $('#example').DataTable();
} );
	</script>
	@include('layouts.footer')
@endsection