@extends('layouts.admin')

@section('content')
          <!-- Breadcrumbs-->
		   @if(Session::has('message'))
		  <div class="alert alert-info">
			  <strong>Info!</strong> {{ Session::get('message') }}
			</div>
			@endif
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="">Server</a>
            </li>
            <li class="breadcrumb-item active">Overview</li>
          </ol>

          <!-- Icon Cards-->
        <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
             Free IP</div>
            <div class="card-body">
			{{$ipsLeft}}
			</div>
		</div>
		<div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
           <a href="{{route('CreateServer')}}"> Add New Server</a></div>
           
		</div>
          <!-- DataTables Example -->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
             Server</div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                     
						<th>ID</th>
						<th>localhost</th>
						<th>Server IP</th>
						<th>Total IP</th>
						<th>View</th>
						<th>Delete</th>
						
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                    
						<th>ID</th>
						<th>localhost</th>
						<th>Server IP</th>
						<th>Total IP</th>
						<th>View</th>
						<th>Delete</th>
                    </tr>
                  </tfoot>
                  <tbody>
                   @foreach($servers as $server)
					<tr>
						
						<td>{{$server->id }}</td>
						<td>{{$server->localhost }}</td>
						<td>{{$server->main_ip}}</td>
						<td>{{count($server->IPS)}}</td>
						
						<td><a href="{{url('admin/server')}}/{{$server->id}}"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
						<td><a href="{{route('DelServer',$server->id)}}"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
					   
					   
						
					</tr>
				@endforeach
                   
                
                  </tbody>
                </table>
              </div>
            </div>
          
          </div>
@endsection