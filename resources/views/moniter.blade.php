@extends('layouts.layoutpage')

@section('content')
	@include('slider')
	<div class="outer-div-sh">	
		<div class="container">	
			<div class="inner-box-sh">
<!--.dataTables_wrapper{ z-index: -9 !important;}-->
<div class="masternode-row ">

	<!-- Top content -->
        <div class="top-content">
                <div class="container">
                        <div class="page-haeading">
                            <h2><strong>Active</strong> Masternodes</h2>
                            
                        </div>
			<div class="table-responsive">
				<strong>Est Balance Runtime for {{'[ '.$total_mns.' ]'}} MN:</strong>
													@if($days > 2)
													{{$days}} Day(s)
													 @else
													{{$days}} Day(s)
													 @endif
			<div class="freeips">
				Available IP's : Smartnodes : <strong>{{$smartip}}</strong>  SATC Masternodes : <strong>{{$satcip}}</strong> XDNA Masternodes : <strong>{{$xdnaip}}</strong>  Other Masternodes : <strong>{{$restip}}</strong>
			</div>										 
		<table id="example" class="table table-striped table-bordered display" style="width:100%">
        <thead>
            <tr>
                <th>Blockchain</th>
				<th>ID</th>
                <th>IP:Port</th>
                <th>Masternode</th>
                <th>Status</th>
                <th>Last Reward Date </th>
    <!--            <th>Last update</th>    -->
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
		<?php //var_dump($usermasternode);die;?>
		@foreach($usermasternode as $node)		
            <tr>
                <td><img style="max-height:30px;"class="trimg"src="/public/{{$node->masternode->logo }}"/>  {{$node->masternode->name }}</td>               
                <td>{{$node->id}}</td>
				<td>{{$node->ip}}:{{$node->port}}</td>				
				@if($node->found)					
					<td style="color:{{$node->found->status=='ENABLED'?'green':'red'}};">
						{{$node->found->status=='ENABLED'?'ENABLED':'EXPIRED'}}
					</td>
				@else
				<td ></td>
				@endif				
				@if($node->found)					
					<td style="color:{{$node->found->status_mn_online?'green':'red'}};">
						{{$node->found->status_mn_online?'Online':'Offline'}}
					</td>
                @else
				<td></td>
                @endif				
                <td>
				@if($node->foundpaid)				
				{{date('Y/m/d',$node->foundpaid->last_paid_date)}}
				@endif
				</td>
    <!--            <td>{{$node->found->last_update??''}}</td>  -->
                <td><a href="home/view/{{$node->id}}"><i class="fa fa-eye" aria-hidden="true"></i></a></td>   
            </tr>
			@endforeach
            

            
          
        </tbody>
		       <tfoot>
            <tr>
               <th>Blockchain</th>
			   <th>ID</th>
                <th>IP:Port</th>
                <th>Masternode</th>
                <th>Status</th>
                <th>Last Reward Date </th>
    <!--            <th>Last update</th>  -->
                <th>Detail</th>
            </tr>
        </tfoot>
    </table></div>
                 
<div class="row page-show">
	<div class="col-sm-12 col-md-6">
		<div class="dataTables_info" id="example_info" role="status" aria-live="polite"></div>
	</div>
	
		<div class="col-sm-12 col-md-6">
			<div class="dataTables_paginate paging_simple_numbers pull-right" id="example_paginate">
			{{ $usermasternode->links() }}
				
			</div>
		</div>
	</div>				 
                
				
				
				
		<!-- ngIf: ctrl.expired().length -->
			<div class="create_master_btn satoshi-masternode">
			
			<button id="create_masternode"type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Create Masternode</button>

			<!-- Modal -->
			
			<div data-backdrop="static" data-keyboard="false" id="myModal" class="modal fade " role="dialog">
			
			  <div class="modal-dialog create-master-pop">
  
				<!-- Modal content-->
				<div class="modal-content">
				 <div class="progress-bar-wrapper"></div>
					<div style="display:none;" id="topLoader"> </div>
					<button style="display:none;"  tm="1"id="animateButton">Animate Loader</button>
					<br/>
					<div style="display:none;" id="barneprogress"class="progress">
					  <div id="dynamic" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
						<span id="current-progress"></span>
					  </div>
					</div>
					<div style="display:none"class="alert alert-success fadein" id="blockscount"></div>
				 <img style="display:none;" class="loadernew" src="{{url('/public/images/newloader.gif')}}"/>
				
				  <div class="modal-header">
					
					<h5 class="modal-title">Create Masternode</h5>
				  </div>
				  <div class="modal-body">
					
					<div id="errordata_div"style="display:none;"class="alert alert-success fadein">

						<a href="#" class="close" data-dismiss="alert">&times;</a>

						<strong>Processing.. </strong> Press next to continue</span>

					</div>


				<div id="successdata_div"style="display:none;"class="alert alert-success fadein">

					<a href="#" class="close" data-dismiss="alert">&times;</a>

					<strong>Success!</strong> <span id="successdata"></span>

				</div>		
			


					<div id="step_1"class="stepcontent">
						<?php //$de_object = new App\Console\Commands\DailyDeduction();
                                   // $satc_coins=$de_object->DollarToSATC();
                     ?>
                        <!-- <label for="blockchain">Blockchain</label> -->
                        <select autocomplete="off" class="form-control  js-example-basic-single" id="blockchain" aria-describedby="blockchainHelp" ng-model="ctrl.data.blockchain" ng-options="item.id as item.name for item in ctrl.blockchains"><option label="- Select blockchain -" value="string:" selected="selected">Select blockchain</option>
						@foreach($allmasternode as $m)
						
						<option coinname="{{$m->name}}"minbal="{{$m->minbal}}"label="{{$m->name}}" value="{{$m->id}}" {{$selected_coin==$m->id?'selected':''}}    >{{$m->name}}</option>
					
						@endforeach
						</select>
                        <small id="blockchainHelp" class="form-text text-muted">The blockchains in this list are supported by SatoshiSolutions. New blockchains will be supported soon.</small>
						@foreach($allmasternode as $m)
						
						<ul class="coin-detail showmecoin{{$m->id}} allcoinav"
						 style="display:{{$selected_coin==$m->id?'block':'none'}};">
							<li><i class="fa fa-hand-o-right" aria-hidden="true"></i>You will need {{$m->minbal}} {{$m->coinname}} as your {{$m->masternode }} collateral.</li>
							<li><i class="fa fa-hand-o-right" aria-hidden="true"></i>{{$Setting->rate??'9'}}SATC ( $0{{$Setting->hosting_rate??'0.13'}} ) will be deducted from your account balance daily for the platform hosting fee.</li>
							
						</ul>
						
						@endforeach
                    </div>
					<div style="display:none"class="stepcontent" id="step_2">
					
						<div class="wallet-content">
								<div class="transaction-content-detail">
									<h6>Open the Debug console</h6>
									<p>Open debug console from the top menu Help -> Debug window -> Console. </p>
								</div>

									<div class="transaction-content-detail""
										<h6>In the Debug console type: <b>getnewaddress</b></h6>
										<p>We will call the output of this command "collateral address". This will hold the funds that enable you to start the masternode. Also, note that this address is your own, as it was generated in your wallet. </p>
									</div>

									<div class="transaction-content-detail">
										<h6>On the "Send" tab of your wallet</h6>
										<p>Send exactly <span class="steptwominbal"></span> (no more, no less) to the collateral address you just generated. </p>                  
									</div>
							</div>
						
					</div>
					<div style="display:none"class="stepcontent" id="step_3">
					
						<div class="c-field u-mb-small has-icon-right wallet-sec wallet-label">
						
						@foreach($allmasternode as $m)
						
						
						<label id="collateral{{$m->id}}"class="c-field__label wallet-id" for="input6" style="display:{{$selected_coin==$m->id?'block':'none'}};">
						Enter the TransactionHash below for your collateral
						(
						{{$m->minbal}}{{$m->coinname}}
						)
						transaction
						 </label>
						@endforeach
						
						
						 
						<label class="c-field__label wallet-id" for="input6">
						Format must be: transactionhash 
						</br> </label>
						<label class="c-field__label wallet-id" for="input6">
						c7a71a90cbdd7441e07eeb693efa44ecc01a1a488ccf02828827123de5fde8ef
						</br> </label>
						
						
						<form id="verify_tranx"method="post"enctype = 'multipart/form-data'action="">
                            <input autocomplete="off"type="hidden" name="_token" id="csrf-token" value="{{csrf_token()}}" />
							<input autocomplete="off"type="hidden" name="coin" id="coinid" value="{{$selected_coin}}" />
							<input autocomplete="off"name="txid"class="c-input c-input--success" id="txid" type="text" value="" placeholder="Transaction hash">
							<!--<span class="sel_index"><input id="tx_index" name="tx_index" placeholder="Tx Index" value="" type="number" min="0" max="1">
							 </span>-->
						</form>
						</div>
						
					</div>
					
					<div style="display:none"class="stepcontent" id="step_4">
							<div class="transaction-content-detail">
									<h6 id="bym">Building your masternode.....</h6>
									<h5 id="bymh"><p>the process can take up to <span id="timeoutgap"></span> minutes </p></h5>
									<p id="bymp"> please press next to continue</p>
																		
								
					
					
							</div>
					</div>
				
				  </div>
				  
				  
				  <div class="modal-footer">
					<button id="modalCloseBtn"type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button id="continue_coin"type="submit" class=" btn btn-primary " >Next</button>
					<button style="display:none;"id="continue_coin_status" type="submit" class="btn btn-primary" ng-class="{'disabled': ctrl.submitDisabled()}" ng-disabled="ctrl.submitDisabled()">Check status</button>
				  </div>
				</div>

			  </div>
			</div>
			</div>
            </div>
        </div>
	<input autocomplete="off" type="hidden"value="{{url('/tranxaction')}}"id="page_url"/>
	<input autocomplete="off" type="hidden"value="1"id="step_id"/>
	<input autocomplete="off" type="hidden"value="Server setup started.."id="swal"/>
	<input autocomplete="off" type="hidden"value=""id="redirect"/>
	<input autocomplete="off" type="hidden"value=""id="currentNodeBuilding"/>
</div>

	
		
		<!--	<div class="footer">
				<div class="inner">
				<p>Copyright 2018 SATOSHI SOLUSTION- use of this website is governed by the Terms and conditions of Use </p>
				<div class="social_icon">
				<a href="#"><i class="fa fa-facebook"></i></a>
				<a href="#"><i class="fa fa-twitter"></i></a>
				<a href="#"><i class="fa fa-google-plus"></i></a>
				</div>
				</div>
			</div>-->
	</div>
	</div>
	</div>
	</div>
	
	<style>
	.copy-button.fa.fa-copy {
				color: white;
		}
		.ENABLED{color:green;}
		.inactive{color:red;}
	</style>
	
	
	@include('layouts.footer')
	

<input type="hidden" id="selected_coin" value="{{$selected_coin}}"/>
@endsection
