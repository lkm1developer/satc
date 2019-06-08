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
              <a href="{{url('/admin/coins')}}">Coins</a>
            </li>
            <li class="breadcrumb-item active">Overview</li>
          </ol>

          <!-- Icon Cards-->
        
		
          <!-- DataTables Example -->
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
				{{ Form::open(array('method'=>'PUT','route' => ['coins.update', $coins->id],'enctype'=>'multipart/form-data')) }}
				
				
				 <input type="hidden" name="_method" value="PUT">
				{{ csrf_field() }}
				
				
				<div class="form-group">
					<label for="exampleInputEmail1">Name</label>
					<input type="text" value="{{$coins->name}}" class="form-control" name="name"placeholder="Name">										
				</div>
			<div class="form-group">
					<label for="exampleInputEmail1">Python Name</label>
					<input type="text" value="{{$coins->py_name}}" class="form-control" name="python_name"placeholder="Name">										
				</div>
			<div class="form-group">
					<label for="exampleInputEmail1">Process Duration</label>
					<input type="text" value="{{$coins->estmtime}}" class="form-control" name="time"placeholder="">										
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Timer timeout</label>
					<input type="text" value="{{$coins->timeoutgap}}" class="form-control" name="timeoutgap"placeholder="Name">										
				</div>
			<div class="form-group">
					<label for="exampleInputEmail1">Short Name</label>
					<input type="text" value="{{$coins->shortnm}}" class="form-control" name="shortnm"placeholder="Name">										
				</div>
			<div class="form-group">
					<label for="exampleInputEmail1">Masternode</label>
					<input type="text" value="{{$coins->shortnm}}" class="form-control" name="masternode"placeholder="Masternode">										
				</div>
			<div class="form-group">
					<label for="exampleInputEmail1">port</label>
					<input type="text" value="{{$coins->port}}" class="form-control" name="port"placeholder="Name">										
				</div>
			
			<div class="form-group">
					<label for="exampleInputEmail1">minbal</label>
					<input type="text" value="{{$coins->minbal}}" class="form-control" name="minbal"placeholder="Name">										
				</div>
			<div class="form-group">
					<label for="exampleInputEmail1">KYD Link</label>
					<input type="text" value="" class="form-control" name="kyd">										
				</div>
			<div class="form-group">
					<label for="exampleInputEmail1">bitcoin talk</label>
					<input type="text" value="{{$coins->bitcoin_talk}}" class="form-control" name="bitcoin_talk"placeholder="Name">										
				</div>
			
			<div class="form-group">
					<label for="exampleInputEmail1">github</label>
					<input type="text" value="{{$coins->github}}" class="form-control" name="github"placeholder="Name">										
				</div>
			
			<div class="form-group">
					<label for="exampleInputEmail1">discord</label>
					<input type="text" value="{{$coins->discord}}" class="form-control" name="discord"placeholder="Name">										
				</div>
			<div class="form-group">
					<label for="exampleInputEmail1">twitter</label>
					<input type="text" value="{{$coins->twitter}}" class="form-control" name="twitter"placeholder="Name">										
				</div>
			<div class="form-group">
					<label for="exampleInputEmail1">website</label>
					<input type="text" value="{{$coins->website}}" class="form-control" name="website"placeholder="Name">										
				</div>
			<div class="form-group">
					<label for="exampleInputEmail1">explorer link</label>
					<input type="text" value="{{$coins->explorer_link}}" class="form-control" name="explorer_link"placeholder="Name">										
			</div>
			<div class="form-group">
					<label for="exampleInputEmail1">Active</label>
					<input type="checkbox"  {{$coins->active?'checked':''}} value="1" class="form-control" name="active">										
			</div>
			<div class="form-group logoupload">
					<label for="exampleInputEmail1">Logo</label>
					<img class="smalllogo"style="max-width:50px;" 
						src="{{url('/public').'/'.$coins->logo}}">
					<input type="file" class="form-control" name="logo">										
			</div>	
			
			  <button type="submit" class="btn btn-primary">Update</button>
			</form>	
			</div>
				

			  </div>
			
		   </div>
		</div>
          
          
@endsection