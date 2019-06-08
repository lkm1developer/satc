@extends('layouts.layoutportfolio')
@section('title', 'Buy Credits')
@section('content')
 <div class="container">
			<div class="satoshi-portfolio m_hgt">
				<div class="container">
				<div class="col-lg-12 col-md-12 col-sm-12 page-haeading">
                            <h2><strong>Satoshi</strong> Portfolio</h2></strong>
                            	<p>Lorem ipsum dolor sit amet
                        </p></div>
					<div class="row">
						<div class="col-lg-3">
							<div class="portfolio-box">
								<h6>24H Revenue</h6>
								<h2>0<span>$</span></h2>
								<a href="#">24H ROI 0%</a>
							</div>
						</div><!--1-->
						
							<div class="col-lg-3">
							<div class="portfolio-box">
								<h6>Weekly Revenue</h6>
								<h2>440<span>$</span></h2>
								<a href="#">Weekly ROI 2.33%</a>
							</div>
						</div><!--2-->
						
							<div class="col-lg-3">
							<div class="portfolio-box">
								<h6>Monthly Revenue</h6>
								<h2>1,885<span>$</span></h2>
								<a href="#">Monthly ROI 10%</a>
							</div>
						</div><!--3-->
						
							<div class="col-lg-3">
							<div class="portfolio-box">
								<h6>Yearly Revenue</h6>
								<h2>22,935<span>$</span></h2>
								<a href="#">Yearly ROI 0%</a>
							</div>
						</div><!--4-->
					</div>
					
					<div id="portfolio-chart">
				<div class="row">
				<div class="col-md-5">
						<div class="panel panel-default">
						<div class="portfolio-box">
							<h6>Portfolio value</h6>
								<h2>22,935<span>$</span></h2>
								<strong>Yearly ROI 0%</strong>
						</div>
						<div class="panel-body">
							<div id="morris-area-chart"></div>
						</div>
					</div>   
					</div>		
					
						<div class="col-md-7">
					<div class="panel panel-default">
						<div class="portfolio-box">
							<h6>Exit</h6>
								<h2>22,935<span>$</span></h2>
								<strong>Yearly ROI 0%</strong>
						</div>
						<div class="panel-body">
							<div id="morris-line-chart"></div>
						</div>
					</div>  
					</div>
					
				</div> 
                <div class="row">
                    <div class="col-md-9 col-sm-12 col-xs-12 bar-chart">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Bar Chart Example
                            </div>
                            <div class="panel-body">
                                <div id="morris-bar-chart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 donut-chart">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Donut Chart Example
                            </div>
                            <div class="panel-body">
                                <div id="morris-donut-chart"></div>
                            </div>
                        </div>
                    </div>

                </div><!-- /. ROW  -->
				
				<div class="upto-date">
				<div class="row satoshi-node">
				<div class="col-lg-9">
				<H2>satoshi</h2>
					<ul class="pull-left">
						<li><strong>2</strong> nodes</li>
						<li>investment<strong> 2000</strong></li>
						<li>Earning<strong> 40</strong></li>
						<li>exits<strong> 10</strong></li>
						
					</ul>
				</div>
				<div class="col-lg-3">
					<ul class="pull-right">
						<li><strong>19,133 $</strong>
						<span>2, 9435 B</span>
						</li>
						<li></li>
					</ul>
				</div>
				</div>
				<!-- /. ROW  -->
				
				
			
						<div class="row">
						<div class="col-lg-3">
							<div class="portfolio-box">
								<h6>Up to date Revenue</h6>
								<h2>377<span> $</span></h2>
								<h5>40<span> Satoshi</span></h5>
								<a href="#">Up to date ROI 2%</a>
							</div>
						</div><!--1-->
						
							<div class="col-lg-3">
							<div class="portfolio-box">
								<h6>Last 24h Revenue</h6>
								<h2>0<span> $</span></h2>
								<h5>0<span> Satoshi</span></h5>
								<a href="#">Last ROI 0%</a>
							</div>
						</div><!--2-->
						
						<div class="col-lg-3">
						  <div class="portfolio-box">
								<h6>Forcasted Monthly Revenue</h6>
								<h2>1885<span> $</span></h2>
								<h5>200<span> Satoshi</span></h5>
								<a href="#">Monthly ROI 10%%</a>
							</div>
						</div><!--3-->
						
						
						
							<div class="col-lg-3">
							<div class="portfolio-box">
								<h6>Forcasted Yearly Revenue</h6>
								<h2>22,935<span> $</span></h2>
								<h5>2,433.34<span> Satoshi</span></h5>
								<a href="#">Yearly ROI 121.67%</a>
							</div>
						</div><!--4-->
					</div>
					</div>

                
        </div><!--end protfolio chart-->
	</div><!--Conatiner-->
			</div>
 </div>

                                       


</main>



 
@include('layouts.footer')
@endsection        