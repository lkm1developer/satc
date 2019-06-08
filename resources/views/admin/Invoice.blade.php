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
              <a href="">Hosting fee Deductions</a>
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
			 
			<select id="selmonth">
			
			@foreach($data['months'] as $month)
			<option 
			<?php if($month == $data['current']){
				echo ' selected="selected" autocomplete="off"';
			}?>
			value="{{$month}}" 
			lkm="{{url('admin/invoice/month/'.$month)}}"
			export="{{url('admin/invoice/export/'.$month)}}"
			>{{$month}}</option>
			@endforeach
			</select>
			<h2>Export </h2>
			<select id="exporttype">
			<option value="">Select</option>
			<option value="pdf">PDF</option>
			<option value="excel">Excel</option>
			</select>
			</div>
			 
            <div class="card-body">
			
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>                     
						<th>User ID</th>
						<th>Email</th>
						<th>Amount</th>
						<th>Frequency</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>                   
						<th>User ID</th>
						<th>Email</th>
						<th>Amount</th>
						<th>Frequency</th>
                    </tr>
                  </tfoot>
                  <tbody>
                   @foreach($data['users'] as $user)
					<tr>						
						<td>{{$user->user_id }}</td>
						<td>{{$user->email }}</td>
						<td>{{$user->amount}}</td>
						<td>{{$user->frequency}}</td>
						
					</tr>
				@endforeach
                   
                
                  </tbody>
                </table>
              </div>
            </div>
          
          </div>
		  <script></script>
@endsection