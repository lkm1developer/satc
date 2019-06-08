@extends('layouts.admin')

@section('content')
          <!-- Breadcrumbs-->
		   @if(Session::has('data'))
		  <div class="alert alert-info">
			  <strong>Info!</strong> {{ Session::get('data') }}
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
            Add new Server</div>
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
				<form action="{{ route('CreateServerPost') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				
				<div class="form-group">
				<label for="exampleInputEmail1">Server IP</label>
				<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="ip"placeholder="Server IP">
										@if ($errors->has('ip'))
											<span class="invalid-feedback">
												<strong>{{ $errors->first('ip') }}</strong>
											</span>
										@endif
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Localhost</label>
				<input type="text" name="localhost"class="form-control" id="exampleInputPassword1" placeholder="Localhost">
									@if ($errors->has('localhost'))
											<span class="invalid-feedback">
												<strong>{{ $errors->first('localhost') }}</strong>
											</span>
										@endif
			  </div>
			   <div class="form-group">
				<label for="exampleInputPassword1">Api Link</label>
				<input type="text" name="api_link"class="form-control" id="exampleInputPassword1" placeholder="Api Link">
									@if ($errors->has('api_link'))
											<span class="invalid-feedback">
												<strong>{{ $errors->first('api_link') }}</strong>
											</span>
										@endif
										
			  </div>
			  
			   <div class="form-group">
				<label for="exampleInputPassword1">Is dedicated for Single Coins</label>
				<select name="dedicated[]" class="custom-select" multiple>
					<option selected value="0">Select Multi Or Single Coin</option>
					@foreach($coins as $c)
					<option value='{{ $c->id }}'>{{ $c->name }}</option>
					@endforeach
				</select>
			  </div>
			  
			  <button type="submit" class="btn btn-primary">Submit</button>
			</form>	
			</div>
				

			  </div>
			
		   </div>
		</div>
          
          
@endsection