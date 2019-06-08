@extends('layouts.admin')



@section('content')

          <!-- Breadcrumbs-->
		  @if(Session::has('emailsent'))
		  <div class="alert alert-info">
			  <strong>Info!</strong> {{ Session::get('emailsent') }}
			</div>
			@endif
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="">{{$user->name}}</a>
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
                  <div class="mr-5"> Email</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="#">
                  <span class="float-left">{{$user->email}}</span>
                 
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
                  <span class="float-left">{{count($user->masternode)}}</span>
                 
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-success o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="fas fa-fw fa-shopping-cart"></i>
                  </div>
                  <div class="mr-5"> Balance</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="#">
                  <span class="float-left">{{$user->usermeta->balance}}</span>
                  
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-danger o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="fas fa-fw fa-life-ring"></i>
                  </div>
                  <div class="mr-5"> Daily Server Fee</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="#">
                  <span class="float-left"></span>
                  
                </a>
              </div>
            </div>
          </div>

          
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-area"></i>
             </div>
            <div class="card-body">
			@if(!$user->active)
			<a href="{{url('admin/user').'/'.$user->id.'/activate'}}"><button type="button" class="btn btn-info">Activate User</button></a>
			@else
			<a href="{{url('admin/user').'/'.$user->id.'/suspend'}}">
			<button type="button" class="btn btn-warning">Suspend User</button>
			</a>
			@endif
			<a href="{{url('admin/user').'/'.$user->id.'/delete'}}">
			<button type="button" class="btn btn-danger">Delete User</button>
			</a>
			<a href="{{url('admin/user').'/'.$user->id.'/mail'}}">
			<button id="emailuser"type="button" class="btn btn-primary">Send Email to user</button>
			</a>
            </div>
           
          </div>

          <!-- DataTables Example -->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
             Masternode</div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                   <thead>
					<tr>
						<th>Id</th>
						<th>Blockchain</th>
						<th>Ip</th>
						<th>Port</th>
						<th>Created date</th>
						<th>Detail</th>
					</tr>
				</thead>
        <tbody>
		<?php //var_dump($allmasternode);?>
		@foreach($user->masternode as $node)
		
		
            <tr>
                <td>{{$node->id}}</td>
                <td>{{$allmasternode[$node->masternode_id] }}</td>
               
                <td>{{$user->ip}}</td>
                <td>{{$node->port}}</td>
                <td>{{ $node->created_at->format('d M Y - H:i:s') }}</td>
				<td><a href="{{url('admin/user')}}/{{$user->id}}/masternode/{{$node->id}}"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
               
            </tr>
			@endforeach
        </tbody>
		       <tfoot>
            <tr>
                <th>Id</th>
                <th>Blockchain</th>
                <th>Ip</th>
                <th>Port</th>
                <th>Created date</th>
                <th>Detail</th>
            </tr>
        </tfoot>
                </table>
              </div>
            </div>
          
          </div>
@endsection



