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
              <a href="{{url('/admin/coins')}}">coins</a>
            </li>
            <li class="breadcrumb-item active">Overview</li>
          </ol>

          <div class="card mb-3">
           
            <div class="card-body">
              <div class="table-responsive">
			  <div class="create_master_btn satoshi-masternode">
			  @if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				<form method="post" action="{{url('/admin/coins')}}" enctype="multipart/form-data">				
				{{ csrf_field() }}
				
				
				<div class="form-group">
					<label for="exampleInputEmail1">Name</label>
					<input type="text" value="" class="form-control" name="name">										
				</div>
			<div class="form-group">
					<label for="exampleInputEmail1">Python Name</label>
					<input type="text" value="" class="form-control" name="python_name">										
				</div>
			<div class="form-group">
					<label for="exampleInputEmail1">Process Duration</label>
					<input type="text" value="" class="form-control" name="time">										
				</div>
			<div class="form-group">
					<label for="exampleInputEmail1">Timer timeout</label>
					<input type="text" value="" class="form-control" name="timeoutgap">										
				</div>
			<div class="form-group">
					<label for="exampleInputEmail1">Short Name</label>
					<input type="text" value="" class="form-control" name="shortnm">										
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Masternode</label>
					<input type="text" value="" class="form-control" name="masternode">										
				</div>
			<div class="form-group">
					<label for="exampleInputEmail1">port</label>
					<input type="text" value="" class="form-control" name="port">										
				</div>
			
			<div class="form-group">
					<label for="exampleInputEmail1">minbal</label>
					<input type="text" value="" class="form-control" name="minbal">										
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">KYD link</label>
					<input type="text" value="" class="form-control" name="kyd">										
				</div>
			
			<div class="form-group">
					<label for="exampleInputEmail1">bitcoin talk</label>
					<input type="text" value="" class="form-control" name="bitcoin_talk">										
				</div>
			
			<div class="form-group">
					<label for="exampleInputEmail1">github</label>
					<input type="text" value="" class="form-control" name="github">										
				</div>
			
			<div class="form-group">
					<label for="exampleInputEmail1">discord</label>
					<input type="text" value="" class="form-control" name="discord">										
				</div>
			<div class="form-group">
					<label for="exampleInputEmail1">twitter</label>
					<input type="text" value="" class="form-control" name="twitter">										
				</div>
			<div class="form-group">
					<label for="exampleInputEmail1">website</label>
					<input type="text" value="" class="form-control" name="website">										
				</div>
			<div class="form-group">
					<label for="exampleInputEmail1">explorer link</label>
					<input type="text" value="" class="form-control" name="explorer_link">										
			</div>
			<div class="form-group">
					<label for="exampleInputEmail1">Active</label>
					<input type="checkbox"   value="1" class="form-control" name="active">										
			</div>
			<div class="form-group logoupload">
					<label for="exampleInputEmail1">Logo</label>
					
					<input type="file" class="form-control" name="logo">										
			</div>	
			
			  <button type="submit" class="btn btn-primary">Update</button>
			</form>	
			</div>
				

			  </div>
			
		   </div>
		</div>
          
          
@endsection