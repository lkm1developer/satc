@extends('layouts.admin')

@section('content')
				@if(Session::has('message'))
				<div class="alert alert-success">
				  <strong>{{ Session::get('message') }}</strong>
				</div>
				@endif
          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Overview</li>
          </ol>

          <!-- Icon Cards-->
          <div class="row">
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-primary o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="fas fa-fw fa-comments"></i>
                  </div>
                  <div class="mr-5"> Users</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="#">
                  <span class="float-left">{{$totalUser}}</span>
                 
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-warning o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="fas fa-fw fa-list"></i>
                  </div>
                  <div class="mr-5"> Masternodes</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="#">
                  <span class="float-left">{{$totalmasternode}}</span>
                  
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-success o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="fas fa-fw fa-shopping-cart"></i>
                  </div>
                  <div class="mr-5"> Coins</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="#">
                  <span class="float-left">{{$totalcoins}}</span>
                
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-danger o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="fas fa-fw fa-life-ring"></i>
                  </div>
                  <div class="mr-5">
				  <a href="{url('/admin/makefree')}}">Make IP's free</a></div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="#">
                  <span class="float-left"></span>
                 
                </a>
              </div>
            </div>
          </div>
		 <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
             Deduction History</div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                  <thead>
                    <tr>
						<th>Last Hour</th>
						<th>Today</th>
						<th>Yesterday</th>
						<th>This Week</th>					  
						<th>This Month</th>
						<th>After Last Withdaw</th>
						<th>Total</th>						
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
						<th>Last Hour</th>
						<th>Today</th>
						<th>Yesterday</th>
						<th>This Week</th>					  
						<th>This Month</th>
						<th>After Last Withdaw</th>
						<th>Total</th>
                    </tr>
                  </tfoot>
                  <tbody>
					<tr>
						<td>{{$lastHours}}</td>
						<td>{{$today}}</td>
						<td>{{$yesterday}}</td>
						<td>{{$week}}</td>					
						<td>{{$month}}</td>
						<td>{{$lastWithdraw}}</td>
						<td>{{$DeductionAll}}</td>
					</tr>
                  </tbody>
                </table>
              </div>
            </div>          
          </div>
          </div>    	
	
@endsection