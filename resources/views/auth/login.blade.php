@extends('layouts.layoutpage')
@section('content')
 <?php $de_object = new App\Http\Controllers\CoinPageController();
                                    $satc_mns_data=$de_object->CryptoStats();
									// echo '<pre>';
									// var_dump($satc_mns_data);die;
						$MNS_TOTAl=		App\usermasternode::where('step',5)->get()->count()	;
									
									?>
<div class="main_my_account avail_masternodde m_hgt">
@include('slider') 
<div class="outer-div-sh">
	<div class="container">
	 <div class="inner-box-sh">
		   <div class="page-haeading">
				<h2><strong>available</strong> Masternodes</h2>
		  </div>
	     <div class="allmns">
				<h3><strong>Hosted Masternodes :</strong> {{$MNS_TOTAl}}</h3>    
		 </div>
	
		 <ul class="masternode-avail">
             @foreach($satc_mns_data as $mn_data)
              <li>
				<div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                    <div class="mainflip">
					
                        <div class="frontside">
						@if($mn_data['kyd'])
									<a class="coinkyd"href=""target="_blank"><img class="coinkydimg"src="{{ url('/public/images/auth.png')}}"></a>
						@endif
						<span class="total_m">{{$mn_data['getAllRunningMns']}}</span>
                            <div class="card">
                                <div class="card-body text-center">
                                   <a href=""><img src="{{ url('/') }}/public{{$mn_data['logo']}}"></a>
								   <h3 class="cname">{{$mn_data['name']}}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="backside">
							 <div class="card">
                                <div class="card-body text-center">
								<div class="cion-text-right">
                                                      <ul>
                                                         <li>Total Masternodes: <span>{{ @$mn_data['mn_data']['active_masternodes']}}</span></li>
                                                         <li>Collateral: <span>{{ @$mn_data['mn_data']['required_coins_for_masternode']}} {{ @$mn_data['mn_data']['coin_ticker']}}</span></li>
                                                         <li>ROI: <span>{{ @$mn_data['mn_data']['roi_percent']}} % /{{ @$mn_data['mn_data']['roi_days']}} days</span></li>
                                                         <li>Average Daily: <span>{{ @$mn_data['mn_data']['daily_income_coins']}} {{@$mn_data['mn_data']['coin_ticker']  }}</span> </li>
                                                          <li>Masternode Price: <span>${{ @round(($mn_data['mn_data']['masternode_worth_usd']),5)}}</span></li>
                                                          <li>Price: <span>${{ @round(($mn_data['mn_data']['price_usd']),5)}}</span></li>
                                                          <li>MN Creation Time: <span>{{$mn_data['estmtime']?$mn_data['estmtime'].' Min':''}} </span></li>
                                                          <li>	@if($mn_data['mno'])
                                                            <a class="coinkydmno"href="{{$mn_data['mno']}}"target="_blank"><img class="coinkydimgmno"src="{{ url('/public/images/mno.png')}}"></a>
                                                            @endif</li>
                                                      </ul>
                                                  </div>
                            </div>
                        </div>
						
                    </div>
                </div>
			</li>
			
				@endforeach
			
		</ul>
	</div>
	</div>
</div>
</div>



@include('layouts.footer')			
@endsection