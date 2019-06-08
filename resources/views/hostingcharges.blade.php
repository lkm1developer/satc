@extends('layouts.layoutpage')
@section('content')
<div class="active-masternode masternode-row m_hgt">
    <div class="top-content">
        <div class="container">
			<div class="page-haeading">
				<h2><strong>Hosting charges History</strong></h2>
			</div>			 
			<div class="table-responsive">
				<table id="examplereverse" class="table table-striped table-bordered display" style="width:100%">
					<thead>
						<tr>
							<th>Id</th>
							<th>Masternode</th>
							<th>Previous Bal</th>
							<th>Post Bal</th>
							<th> Date </th>
							
							
						</tr>
					</thead>
					<tbody>
					@foreach($deductions as $deduction)		
						<tr>
							<td>{{$deduction->id }}</td>
							<td>
							@if($deduction->coin)
								
															
									{{$deduction->masternode->id?:'' }}
								
							@endif
							</td>							
							<td>{{$deduction->pre_balance}}</td>
							<td>{{$deduction->post_balance}}</td>
							<td>{{$deduction->created_at}}</td>
							
							
						</tr>
					@endforeach
					</tbody>
					<tfoot>
						<tr>
						    <th>Id</th>
						    <th>Masternode</th>
							<th>Previous Bal</th>
							<th>Post Bal</th>
							<th>Date</th>
							
							
						</tr>
					</tfoot>
				</table>
			</div>                 
			<div class="row page-show">
				<div class="col-sm-12 col-md-6">
					<div class="dataTables_info" id="example_info" role="status" aria-live="polite"></div>
				</div>
				<div class="col-sm-12 col-md-6">
					<div class="dataTables_paginate paging_simple_numbers pull-right" id="example_paginate">
					{{ $deductions->links() }}						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	</div>
@include('layouts.footer')
@endsection
