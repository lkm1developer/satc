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
              <i class="fas fa-chart-area"></i></div>
            <div class="card-body">
            <a href="{{url('/admin/makefree')}}">Make IP's free</a></div>
            </div>
           
          </div>

          <!-- DataTables Example -->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
             Hosting Charges </div>
			 <form method="post"action="{{route('UpdateSettings')}}">
			 {{csrf_field()}}
				<div class="card-body">
				<div class="row ">
					<div class="col-md-4">
						Address 
					</div>
					<div class="col-md-8">
					<input type="text" value="{{$settings->admin_address}}"name="admin_address"/>
					@if($errors->has('admin_address'))
					<div class="alert alert-warning">
					  <strong>{{$errors->first('admin_address')}}</strong> 
					</div>
					@endif
					</div>
					</div>
				<div class="row ">	
					<div class="col-md-4">
					Hosting Rate 
					</div>
					<div class="col-md-8">
					<input type="text" value="{{$settings->hosting_rate}}"name="hosting_rate"/>
					@if($errors->has('hosting_rate'))
					<div class="alert alert-warning">
					  <strong>{{$errors->first('hosting_rate')}}</strong> 
					</div>
					@endif
					</div>
					</div>
				<div class="row ">
					<div class="col-md-4">
					<input class="btn btn-danger"type="submit"value="update">
					</div>
					</div>
					</form>
				</div>
          
          </div>
		  <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
            Website Management</div>
			
				<div class="card-body">
				
				 <form method="post"action="{{route('SiteDown')}}">
				 
					  {{csrf_field()}}
				<div class="row ">				
					<div class="col-md-4">
						down Till  
					</div>
					<div class="col-md-8">
				
						<input placeholder="Dec 10, 2018 14:30:25"required type="text" value="{{$settings->downtill}}"name="downtill"/>
						@if($errors->has('downtill'))
							<div class="alert alert-warning">
							  <strong>{{$errors->first('downtill')}}</strong> 
							</div>
						@endif
					</div>
				</div>
				<div class="row ">
					<div class="col-md-4">
					<input type="submit"class="btn btn-danger"value="Put on maintenance"/>	
					</div>
				</div>	
					
				</form>
				<div class="row ">
					<div class="col-md-4">
					
					</div>
				</div>	
			</div>
		</div>
			
			 <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
				<a href="{{route('SiteUp')}}"class="btn btn-primary" >put live</a>
			</div>		
			</div>		
	
@endsection