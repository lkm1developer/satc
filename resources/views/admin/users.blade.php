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
             Users</div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                     
						<th>Email</th>
						<th>Active</th>
						<th>Email verified</th>
						<th>Balance</th>
						<th>Masternode</th>
						<th>Payment</th>
						<th>Detail</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                    
						<th>Email</th>
						<th>Active</th>
						<th>Email verified</th>
						<th>Balance</th>
						<th>Masternode</th>
						<th>Payment</th>
						<th>Detail</th>
                    </tr>
                  </tfoot>
                  <tbody>
                   @foreach($users as $user)
					<tr>
						
						<td>{{$user->email }}</td>
						<td>{{$user->active?'Active':'Suspended' }}</td>
						<td>{{$user->valid?'verified':'unverified' }}</td>
						<td>{{$user->Usermeta->balance}}</td>
						<td>{{$user->masternode->count()}}</td>
						<td><a href="{{url('admin/user')}}/{{$user->id}}/transactions"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
					   
					   
						<td><a href="{{url('admin/user')}}/{{$user->id}}"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
					</tr>
				@endforeach
                   
                
                  </tbody>
                </table>
              </div>
            </div>
          
          </div>
@endsection