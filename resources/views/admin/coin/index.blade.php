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
              <a href="{{url('/admin/coins/')}}">Coins</a>
            </li>
            <li class="breadcrumb-item active">Overview</li>
          </ol>

          <!-- Icon Cards-->
       
		<div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
           <a href="{{url('/admin/coins/create')}}"> Add New Coin</a></div>
           
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
                    <tr><th>ID</th>
						<th>Name</th>
						<th>Port</th>
						<th>Min Bal</th>						
						<th>Active</th>
						<th>Masternode</th>
						<th>View</th>
						<th>Delete</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>                    
						<th>ID</th>
						<th>Name</th>
						<th>Port</th>
						<th>Min Bal</th>						
						<th>Active</th>
						<th>Masternode</th>
						<th>View</th>
						<th>Delete</th>
                    </tr>
                  </tfoot>
                  <tbody>
                   @foreach($coins as $coin)
					<tr>
						
						<td>{{$coin->id }}</td>
						<td><img class="smalllogo"style="max-width:50px;" 
						src="{{url('/public').'/'.$coin->logo}}">{{$coin->name }}</td>
						<td>{{$coin->port}}</td>
						<td>{{$coin->minbal}}</td>
						<td>{{$coin->active?'Enabled':'Disabled'}}</td>
						<td>{{count($coin->MNS)}}</td>						
						<td><a href="{{url('admin/coins')}}/{{$coin->id}}"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
						<td>
						{{ Form::open(array('method'=>'destroy','route' => ['coins.destroy', $coin->id])) }}
						{{ method_field('delete') }}
						{{ csrf_field() }}
						<button><i class="fa fa-trash" aria-hidden="true"></i></button>
						</form>
						
						</td>
					</tr>
				@endforeach
                   
                
                  </tbody>
                </table>
              </div>
            </div>
          
          </div>
@endsection