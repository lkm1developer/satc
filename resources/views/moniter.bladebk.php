@extends('layouts.layoutpage')

@section('content')
<div class="active-masternode masternode-row">
	<!-- Top content -->
        <div class="top-content">
                <div class="container">
                        <div class="page-haeading">
                            <h2><strong>Active</strong> Masternodes</h2>
                            	<p>
                        </div>
			<div class="row">
				<div class="col-lg-6 col-mg-6">
					<div class="dataTables_length" id="example_length">
						<label>List of your current Masternodes</label><select name="example_length" aria-controls="example" class="form-control form-control-sm">
						<option value="10">10</option>
						<option value="25">25</option>
						<option value="50">50</option>
						<option value="100">100</option>
						</select>
					</div>
				</div>
			<div class="col-lg-6 col-mg-6">
				<div id="example_filter" class="dataTables_filter pull-right">
				<label>Search:</label><i class="fa fa-search"></i><input type="search" class="form-control form-control-sm" placeholder="" aria-controls="example">
				</div>
				</div>
			</div>
		<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Blockchain</th>
                <th>Ip</th>
                <th>Status</th>
                <th>Created date</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody><pre>
		<?php //var_dump($allmasternode);?>
		@foreach($usermasternode as $node)
		
		
            <tr>
                <td>{{$node->masternode_id}}</td>
                <td>{{$node->masternode->name }}</td>
               
                <td>{{$user->ip}}</td>
                <td>{{$node->status}}</td>
                <td>{{ $node->created_at->format('d M Y - H:i:s') }}</td>
                <td><a href="home/view/{{$node->id}}"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
            </tr>
			@endforeach
            

            
          
        </tbody>

    </table>
                 
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
			
			<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Create Masternode</button>

			<!-- Modal -->
			<div id="myModal" class="modal fade" role="dialog">
			  <div class="modal-dialog create-master-pop">

				<!-- Modal content-->
				<div class="modal-content">
				
				  <div class="modal-header">
					
					<h5 class="modal-title">Create Masternode</h5>
				  </div>
				  <div class="modal-body">
				  
					
					<div id="errordata_div"style="display:none;"class="alert alert-danger fadein">

						<a href="#" class="close" data-dismiss="alert">&times;</a>

						<strong>Error!</strong> <span id="errordata"></span>

					</div>


				<div id="successdata_div"style="display:none;"class="alert alert-success fadein">

					<a href="#" class="close" data-dismiss="alert">&times;</a>

					<strong>Success!</strong> <span id="successdata"></span>

				</div>		



					<div id="step_1"class="form-group stepcontent">
                        <!-- <label for="blockchain">Blockchain</label> -->
                        <select autocomplete="off" class="form-control ng-pristine ng-valid ng-empty ng-touched" id="blockchain" aria-describedby="blockchainHelp" ng-model="ctrl.data.blockchain" ng-options="item.id as item.name for item in ctrl.blockchains"><option label="- Select blockchain -" value="string:" selected="selected">Select blockchain</option>
						@foreach($allmasternode as $m)
						<option coinname="{{$m->name}}"minbal="{{$m->minbal}}"label="{{$m->name}}" value="{{$m->id}}">{{$m->name}}</option>
						@endforeach
						</select>
                        <small id="blockchainHelp" class="form-text text-muted">The blockchains in this list are supported by SatoshiSolutions. New blockchains will be supported soon.</small>
						@foreach($allmasternode as $m)
						
						<ul class="coin-detail showmecoin{{$m->id}} allcoinav"style="display:none;">
							<li><i class="fa fa-hand-o-right" aria-hidden="true"></i>You will need {{$m->minbal}} {{$m->coinname}} as your masternode collateral.</li>
							<li><i class="fa fa-hand-o-right" aria-hidden="true"></i>0.5 SATC will be deducted from your account balance daily for the platform hosting fee.</li>
							<li><i class="fa fa-hand-o-right" aria-hidden="true"></i>The {{$m->coinname}} wallet does not lock MN collateral. Please make sure to lock it manually so you won't spend the collateral by mistake.</li>
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
										<h6>In the Debug console type <b> "getnewaddress" insert your masternode name here</b> then hit Enter </h6>
										<p>We will call the output of this command "collateral address". This will hold the funds that enable you to start the masternode. Also, note that this address is your own, as it was generated in your wallet. </p>
									</div>

									<div class="transaction-content-detail">
										<h6>On the "Send" tab of your wallet</h6>
										<p>Send exactly <span class="steptwominbal"></span> (no more, no less) to the collateral address you just generated. Make sure that "Subtract fee from amount" is NOT checked. </p>                  
									</div>
							</div>
						
					</div>
					<div style="display:none"class="stepcontent" id="step_3">
					
						<div class="c-field u-mb-small has-icon-right wallet-sec">
						<label class="c-field__label wallet-id" for="input6">After sending the payment, Enter the transaction hash below.</label>
						<form id="verify_tranx"method="post"enctype = 'multipart/form-data'action="">
                            <input autocomplete="off"type="hidden" name="_token" id="csrf-token" value="{{csrf_token()}}" />
							<input autocomplete="off"type="hidden" name="coin" id="coinid" value="" />
							<input autocomplete="off"name="txid"class="c-input c-input--success" id="txid" type="text" value="" placeholder="Transaction hash">
							
						</form>
						</div>
						
					</div>
					
					<div style="display:none"class="stepcontent" id="step_4">
							<div class="transaction-content-detail">
									<h6>Masternode Details</h6>
									<p>Masternode building .... </p>
									
					<div class="prgrs"style="margin:0px;">
						<div id="prgrsbar"class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="20"aria-valuemin="0" aria-valuemax="100" style="width:20%;">
											<span class="prcnt">20%</span>
						</div>
					</div>
					
							</div>
					</div>
				
				  </div>
				  
				  
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="continue_coin"type="submit" class=" btn btn-primary disabled" ng-class="{'disabled': ctrl.submitDisabled()}" ng-disabled="ctrl.submitDisabled()" disabled="disabled">Next</button>
				  </div>
				</div>

			  </div>
			</div>
			</div>
            </div>
        </div>
	<input autocomplete="off" type="hidden"value="{{url('/tranxaction')}}"id="page_url"/>
	<input autocomplete="off" type="hidden"value="1"id="step_id"/>
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
	
	
	<script>
	$(document).ready(function() {
    $('#example').DataTable();
} );
	</script>
	@include('layouts.footer')
@endsection
