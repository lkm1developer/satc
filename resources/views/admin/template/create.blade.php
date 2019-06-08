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
              <a href="{{url('/admin/template')}}">coins</a>
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
				<form method="post" action="{{url('/admin/template')}}" enctype="multipart/form-data">				
				{{ csrf_field() }}
				
				
				<div class="form-group">
					<label for="exampleInputEmail1">Ttile</label>
					<input type="text" value="" class="form-control" name="title">										
				</div>
			<div class="form-group">
					<label for="exampleInputEmail1">Template</label>
															
				</div>
			<div class="form-group">
					
					<textarea id="my-editor" name="template" class="form-control"></textarea>										
				</div>
			
			  <button type="submit" class="btn btn-primary">Save</button>
			</form>	
			</div>
				

			  </div>
			
		   </div>
		</div>
          
  <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script>
  var options = {
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}',
  };
</script>
<script>
CKEDITOR.replace('my-editor', options);
</script>    
@endsection