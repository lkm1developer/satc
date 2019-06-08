@extends('layouts.layoutpage')
@section('content')
		
		<!---View detail page-->
		<div class="view-page m_hgt stats-page">
			@include('slider')
			<div class="outer-div-sh">
			  <div class="container">
				 <div class="inner-box-sh">
				   <div class="page-haeading">
					  <h2> SATOSHI SOLUTIONS STATS</h2>
				  </div>
				     <div class="top-stats">
					    <div class="row">
							 <div class="width20">
								  <div class="panel panel-default">
									  <h4 class="card-header-danger">Hosted MN </h4>
									  <p>{{$mnsHosted}}</p>
								  </div>
							 </div>
							  <div class="width20">
								   <div class="panel panel-default">
									  <h4 class="card-header-danger">Coins Listed </h4>
									  <p>{{$coinsListed}}</p>
								   </div>
							   </div>
							  <div class="width20">
								 <div class="panel panel-default">
									 <h4 class="card-header-danger">Registered Users</h4>
									 <p>{{$usersListed}}</p>
								 </div>
							 </div>
							 <div class="width20">
								  <div class="panel panel-default">
									<h4 class="card-header-danger">Build Today </h4>
									 <p>{{$mnsHostedToday}}</p>
								  </div>
							 </div>
							 <div class="width20">
								 <div class="panel panel-default">
									 <h4 class="card-header-danger">Total Worth MN</h4>
									 <p>${{$worth}}</p>
								 </div>
							 </div>
				      	  </div>
						</div>   
				     <div class="top-user">
					     <div class="container">
							 <div class="row ">						
								 <div class="col-lg-12 col-md-12 col-xs-12 mb-2">
								     <div class="panel panel-default">
									     <h4 class="card-header-primary">Top 10 Users</h4>
										 <ul>
										<?php $i=0; ?>	@foreach($top_users as $users=>$users_data) 
										<?php ++$i;?>
										     <li><p class="card-header-danger">{{$i}}</p>{{$users_data->name}}<span>{{$users_data->occurrences}}</span></li>
											
											 @endforeach
										 </ul>
									  </div>
								 </div>
							 </div>
						 </div>
					 </div>
					<section id="stats-div">
						<div class="container">
							<div class="row ">						
								<div class="col-lg-6 col-md-12 col-xs-12 mb-2">
								  <div class="panel panel-default">
								     <h4 class="card-header-primary">Domination Mn against Platform</h4>
									@foreach($lefts as $key=>$mn_data)
										<div id="{{strtolower($mn_data['name'])}}" class="row">
											<div class="col-md-5">
												<div class="cionimgleft">
													<img style="float:left;" width="30px" src="{{ url('/') }}/public{{$mn_data['logo']}}">
													<h6>{{$mn_data['name']}}</h6>
												</div>
											</div>
											<div class="col-md-2">							
													<div class="totalmasternode">
														{{$mn_data['getAllRunningMns']}}/{{$mnsHosted}}
													</div>
												</div>
											<div class="col-md-3">

												@if($mn_data['percentLeft'])
													<div class="progress">
													  <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"
													  aria-valuenow="{{$mn_data['percentLeft']}}" aria-valuemin="0" aria-valuemax="100" style="width:{{$mn_data['percentLeft']}}%">
													  </div>
													</div>
													@endif
												</div>
												<div class="col-md-2"><strong>{{$mn_data['percentLeft']}}%</strong>
												</div>
										</div>
									@endforeach
									</div>
								</div>							
								<div class="col-lg-6 col-md-12 col-xs-12 mb-2">
								<div class="panel panel-default">
								  <h4 class="card-header-primary">Domination Mn against Network</h4>
									@foreach($rights as $key=>$mn_data)
										<div id="{{strtolower($mn_data['name'])}}"class="row">
											<div class="col-md-5">
												<div class="cionimgleft">
													<img style="float:left;"width="30px" src="{{ url('/') }}/public{{$mn_data['logo']}}">
													<h6>{{$mn_data['name']}}</h6>
												</div>
												 
											</div>
												<div class="col-md-2">							
													<div class="totalmasternode">
														{{$mn_data['getAllRunningMns']}}/{{$mn_data['apidata']['nb_node']}}
													</div>
												</div>
												<div class="col-md-3">
												@if($mn_data['percentRight'])
													<div class="progress">
													  <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"
													  aria-valuenow="{{$mn_data['percentRight']}}" aria-valuemin="0" aria-valuemax="100" style="width:{{$mn_data['percentRight']}}%">
													  </div>
													</div>
													@endif
												</div>
												<div class="col-md-2">	
													<strong>{{$mn_data['percentRight']}}%</strong>
												</div>
										</div>
									@endforeach
									</div>
								</div>							
								
							</div>
						</div>
					</section>
				 </div>
				 <div id="mychart"class="panel panel-default">
			  <div class="myChart" width="" height=""><h4 class="card-header-primary">Build History</h4></div>
			  </div>
			  </div>
			  
			</div>
		</div>
		<script>
		function createConfig(gridlines, title) {
        return {
            type: 'line',
            data: {
                labels: [<?php echo implode(" ,",$monthChartDay)?>],
                datasets: [{
                    label: '',backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(153, 102, 255, 1)',
                    ],
                    data: [<?php echo implode(" ,",$monthChartData)?>],
                    fill: true,
					fillColor : "#ffbb33",
					strokeColor : "#57d5cd",
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: false,
                    text: title
                },
                scales: {
                    xAxes: [{
                        gridLines: gridlines
                    }],
                    yAxes: [{
                        gridLines: gridlines,
                        ticks: {
                            min: 0,
                            max: 2000,
                            stepSize: 400
                        }
                    }]
                }
            }
        };
    }

    window.onload = function() {
        var container = document.querySelector('.myChart');

        [{
            title: '',
            gridLines: {
                display: true
            }
        }].forEach(function(details) {
            var div = document.createElement('div');
            div.classList.add('chart-container');

            var canvas = document.createElement('canvas');
            div.appendChild(canvas);
            container.appendChild(div);

            var ctx = canvas.getContext('2d');
            var config = createConfig(details.gridLines, details.title);
            new Chart(ctx, config);
        });
    };
</script>
<style>
div#mychart h4.card-header-primary {
    font-size: 14px;
    left: 0;
    position: absolute;
    top: -16px;
    right: 0;
    max-width: 200px;
    margin: 0 auto;
    padding: 10px;
    color: #fff;
    text-align: center;
}
div#mychart {
    float: left;
    width: 100%;
    padding: 35px 25px 25px 25px;
}</style>
	@include('layouts.footer')
@endsection