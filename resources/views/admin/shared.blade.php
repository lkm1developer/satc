@extends('layouts.admin')

@section('content')
          <!-- Breadcrumbs-->
		   @if(Session::has('DeleteUser'))
		  <div class="alert alert-info">
			  <strong>Info!</strong> {{ Session::get('DeleteUser') }}
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
             Shared Masternode Reservation</div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                     <th>Shared masternode Id</th>
						<th>Coin</th>
						<th>Reserved</th>
						<th>Deposited</th>
						<th>Masternode Created</th>						
						<th>Detail</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Shared masternode Id</th>
						<th>Coin</th>
						<th>Reserved</th>
						<th>Deposited</th>
						<th>Masternode Created</th>						
						<th>Detail</th>
                    </tr>
                  </tfoot>
                  <tbody>
                   @foreach($Sharenodes as $Sharenode)
				
					<tr>
						<td>{{$Sharenode->id}}</td>
						<td>{{$Sharenode->Coin->coinname }}</td>
						<td>{{$Sharenode->reserved }}</td>
						<td>{{$Sharenode->deposited }}</td>
						@if($Sharenode->completed)
							<td><a href="{{url('admin/user')}}/{{Auth::id()}}/masternode/{{$Sharenode->usermasternode->id}}"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
						@else
							@if($Sharenode->deposited==20)
							<td><a href="{{url('admin/shared')}}/{{$Sharenode->id}}/create">Create</a></td>
						@else
							<td>	</td>
							@endif
							@endif
							
						
						<td><a href="{{url('admin/shared')}}/{{$Sharenode->id}}"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
					</tr>
				@endforeach
                   
                
                  </tbody>
                </table>
              </div>
            </div>
          
          </div>
@endsection