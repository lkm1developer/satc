@extends('layouts.admin')

@section('content')
          <!-- Breadcrumbs-->
		   @if(Session::has('data'))
		  <div class="alert alert-info">
			  <strong>Info!</strong> {{ Session::get('data') }}
			</div>
			@endif
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="">Users</a>
            </li>
            <li class="breadcrumb-item active">Overview</li>
          </ol>

          <!-- Icon Cards-->
        
		
          <!-- DataTables Example -->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
             Create Shared Masternode </div>
            <div class="card-body">
              <div class="table-responsive">
			  <div class="create_master_btn satoshi-masternode">
					<div id="errordata_div"style="display:none;"class="alert alert-danger fadein">
						<strong>Error!</strong> <span id="errordata"></span>
					</div>
					<div id="successdata_div"style="display:none;"class="alert alert-success fadein">
					<strong>Success!</strong> <span id="successdata"></span>
					</div>		
				<div class="prgrs"style="margin:0px;" >
						<div id="prgrsbar"class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="{{$masternode->step*20??'0'}}"aria-valuemin="0" aria-valuemax="100" style="width:{{$masternode->step*20??'0'}}%;">
						<span class="prcnt">{{$masternode->step*20??'0'}}%</span>
						</div>
				</div>	
				  <div class="modal-footer">
					
                    <button id="continue_coin"type="submit" class=" btn btn-primary " >Next</button>
				  </div>
				</div>
				

			  </div>
			
					<input type="hidden"value="{{$masternode->masternode_id??''}}"id="coinid"/>
					<input type="hidden"value="{{$masternode->sharednode_id??''}}"id="sharednode_id"/>
					<input autocomplete="off" type="hidden"value="1"id="step_id"/>
					
		   </div>
		</div>
          
          
@endsection