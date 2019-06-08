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
              <a href="{{url('/admin/template/')}}">Email Template</a>
            </li>
            <li class="breadcrumb-item active">Overview</li>
          </ol>

          <!-- Icon Cards-->
       
		<div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
           <a href="{{url('/admin/template/create')}}"> Add New Template</a></div>
           
		</div>
          <!-- DataTables Example -->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
             Templates</div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr><th>ID</th>
						<th>Title</th>
						<th>View</th>
						<th>Send Email</th>
						<th>Delete</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>                    
						<th>ID</th>
						<th>Title</th>
						<th>View</th>
						<th>Send Email</th>
						<th>Delete</th>
                    </tr>
                  </tfoot>
                  <tbody>
                   @foreach($templates as $Template)
					<tr>
						
						<td>{{$Template->id }}</td>					
						<td>{{$Template->title }}</td>					
						<td><a href="{{url('admin/template')}}/{{$Template->id}}"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
						<td>
						{{ Form::open(array('method'=>'post','route' => ['templatesend', $Template->id])) }}
						{{ method_field('post') }}
						{{ csrf_field() }}
						<button>Send</button>
						</form>
						<td>
						{{ Form::open(array('method'=>'destroy','route' => ['template.destroy', $Template->id])) }}
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