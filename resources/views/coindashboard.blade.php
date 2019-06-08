@extends('layouts.layout')

@section('content')
			<!--Medicoin sec-->
	<div class="medicoin-page main_active_section">
	<div class="container">
	<div class="inner-page-title">
		<h2>Coin<strong> List</strong></h2>
		<p align="center">The platform enables everyone to launch a masternode without linux or programming knowledge. Below you can find a list of supported blockchains, more are continuously added.</p>
	</div>
	
	<div class="features-table">
  <div class="os-container">
   <div class="row no-gutters">
	  @foreach($coins as $key=>$coin)
		  <div class="col-xl-4 col-sm-6 b-l b-t feature-cell">
		  <div class="feature-box">
			<div class="feature-icon">
			@if($coin->logo)
			  <i><img class="coinlogo"src="{{ URL::asset('public/images/').'/'.$coin->logo}}" alt=""></i>
			@else
				 <i><img class="coinlogo"src="{{ URL::asset('public/images/medicoin.png')}}" alt=""></i>
			@endif
				</div>
			<h6 class="feature-title">{{$coin->coinname}}</h6>
			<div class="feature-text">The base currency of the Medicoin Platform, masternodes are available since block 200.</div>
			<div class="mediacin-btn">
				<a target="_blank"href="{{url('/masternode')}}">Launch Master Node</a>
				<a target="_blank"href="{{$coin->website}}">Website</a>
				<a target="_blank"href="{{$coin->ex}}">Explorer</a>
			</div>
		  </div><!--1-->
		  </div><!--1-->
	@endforeach	  
	
    </div>
	
	
	
  </div>
</div>
	
	</div>
	</div>
	<!--End Medicoin sec-->
	
	
	
	@include('layouts.footer')
			
	
@endsection