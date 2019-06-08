@extends('layouts.layout')

@section('content')
		<div class="slider_main m_hgt">
			<div class="inner">
				<!-- <div class="top_slider _section">
				<img src="{{ url('/') }}/public/images/left_col_img.png">
				</div> -->
				<div class="left_slider _section col-sm-12">
				<h6>Welcome to</h6>
				<h1>HOST SWYFT.Network</h1>
				<p>With just a couple clicks HOST SWYFT.N can help you setup your masternode automatically for any coin available on the platform. Build and monitor your masternode in minutes instead of having to learn and read long complicated guides..</p>
				<div class="read_more">
				<a href="/moniter">Enter</a>
				</div>
			<!--	<div class="left_slider _section col-sm-12">
				<h1>SWAPPER</h1>
				<p></p>
				<div class="read_more">
				<a href="https://swapper.satoshisolutions.online">Enter</a>
				</div>
				</div>
				<div class="left_slider _section col-sm-12">
				<h1>PRESALE</h1>
				<p></p>
				<div class="read_more">
				<a href="https://swapper.satoshisolutions.online/presale">Enter</a>
				</div>  -->
				</div>
				<!-- <div class="right_slider _section col-sm-6">
				<img src="{{ url('/') }}/public/images/left_col_img.png">
				</div> -->
				<div class="coin-logo">
				     <ul>
						 @foreach($coins as $c)
						 <li><img  src="{{ url('/public'.$c) }}"></li>
						 @endforeach
					 </ul>
				</div>
			</div>
			</div>
		</div>

				
		
			
			
	@include('layouts.footer')
			
	
	@endsection