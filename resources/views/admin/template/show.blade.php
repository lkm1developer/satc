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
              <a href="{{url('/admin/template')}}">Template</a>
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
				{{ Form::open(array('method'=>'PUT','route' => ['template.update', $template->id],'enctype'=>'multipart/form-data')) }}
				
				
				 <input type="hidden" name="_method" value="PUT">
				{{ csrf_field() }}
				
				
				<div class="form-group">
					<label for="exampleInputEmail1">Title</label>
					<input type="text" value="{{$template->title}}" class="form-control" name="title" placeholder="Title">										
				</div>
			<div class="form-group">
					<label for="exampleInputEmail1">Template</label>
															
				</div>
			<div class="form-group">
					<textarea id="my-editor" name="template" class="form-control">{!! $template->html !!}</textarea>					
				</div>
			  <button type="submit" class="btn btn-primary">Update</button>
			</form>	
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

	

			  </div>
			
		   </div>
		</div>
          
          
@endsection