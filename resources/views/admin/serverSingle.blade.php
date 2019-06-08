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
			@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
          <!-- Icon Cards-->
         <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
						 	Dedicated for 
						</div>
            <div class="card-body">
							
						@if(count($dedicatedfor)>0)
						{{ Implode(' , ', $dedicatedfor) }}
						@endif
						</div>
					</div>
         <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
						 		Free IP
						</div>
            <div class="card-body">
							{{$ipsLeft}}
						</div>
					</div>
         <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
            Add IP to this Server</div>
            <div class="card-body">			
			
			<form action="{{ route('ServerADDIP',$server->id) }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				 <a href="{{route('getDownload')}}">Download  sample file</a><br/>
				Upload IP  text file<br /><br />
				<input type="file" name="ipfile" />
				<br /><br />
				<input type="submit" value="Add IP" />
			</form>		
			</div>
		</div>
          <!-- DataTables Example -->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
             Server IP {{$server->main_ip}}</div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                     
						<th>ID</th>
						<th>IP</th>
						<th>Used</th>
						<th>Masternode ID</th>
						<th>Delete</th>
						
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                    
						<th>ID</th>
						<th>IP</th>
						<th>Used</th>
						<th>Masternode ID</th>
						<th>Delete</th>
                    </tr>
                  </tfoot>
                  <tbody>
                   @foreach($ips as $ip)
					<tr>						
						<td>{{$ip->id }}</td>
						<td>{{$ip->ip }}</td>
						<td>{{$ip->used?'Yes':'Not'}}</td>
						<td>{{$ip->MNS->id??''}}</td>						
						<td>
						@if(!$ip->used)
						<a href="{{url('admin/server/')}}/{{$server->id}}/ip/{{$ip->id}}/delete"><i class="fa fa-trash" aria-hidden="true" alt="Delete"></i></a>
						@endif
						</td>
					</tr>
				@endforeach
                   
                
                  </tbody>
                </table>
              </div>
            </div>
          
          </div>
@endsection