@extends('layouts.admin')

@section('content')
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
                  <span class="float-left"></span>
                 
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
                  <span class="float-left"></span>
                  
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
                  <span class="float-left"></span>
                
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-danger o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="fas fa-fw fa-life-ring"></i>
                  </div>
                  <div class="mr-5"> Shared Masternode</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="#">
                  <span class="float-left">13</span>
                 
                </a>
              </div>
            </div>
          </div>

          <!-- Area Chart Example
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-area"></i>
              Area Chart Example</div>
            <div class="card-body">
              <canvas id="myAreaChart" width="100%" height="30"></canvas>
            </div>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
          </div>-->

          <!-- DataTables Example -->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
             Transactions</div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTableTransactions" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                     <th>ID</th>
					 <th>Prev. Bal</th>
					  <th>Post Bal</th>
					  <th>Amount</th>
					  <th>Email</th>					  
					  <th>Time</th>
						
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                     
					 <th>ID</th>
					  <th>Prev. Bal</th>
					  <th>Post Bal</th>
					  <th>Amount</th>
					   <th>Email</th>
					  <th>Time</th>
                    </tr>
                  </tfoot>
                  <tbody>
                   @foreach($deductions as $deduction)
					<tr>
						
						
						<td>{{$deduction->id}}</td>
						<td>{{$deduction->pre_balance}}</td>
						<td>{{$deduction->post_balance}}</td>
						<td>{{$deduction->amount}}</td>
						<td>{{$deduction->user->email??'' }}</td>
						<td>{{$deduction->created_at}}</td>
						
											 
					</tr>
				@endforeach
                   
                
                  </tbody>
                </table>
              </div>
            </div>
          
          </div>
@endsection