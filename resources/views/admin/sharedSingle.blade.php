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
						<th>Id</th>
						<th>user</th>
						<th>Slot</th>
						<th>Deposited</th>
						<th>Payout Address</th>						
						<th>Deposite Address</th>
						<th>Reservated till</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Id</th>
						<th>user</th>
						<th>Slot</th>
						<th>Deposited</th>
						<th>Payout Address</th>						
						<th>Deposite Address</th>
						<th>Reservated till</th>
                    </tr>
                  </tfoot>
                  <tbody>
                   @foreach($Sharenodes->reservation as $Sharenode)
					<tr>
						<td>{{$Sharenode->id}}</td>
						<td>{{$Sharenode->user_id}}</td>
						<td>{{$Sharenode->slot }}</td>
						<td>{{$Sharenode->deposited?'Yes':'No' }}</td>
						<td>{{$Sharenode->payout_address }}</td>
						<td>{{$Sharenode->deposite_address }}</td>
						<td>{{$Sharenode->reserved_till }}</td>
					</tr>
				@endforeach                   
                
                  </tbody>
                </table>
              </div>
            </div>
          
          </div>
@endsection