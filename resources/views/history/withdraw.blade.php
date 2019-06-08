@extends('layouts.layoutpage')
@section('content')
<div class="active-masternode masternode-row m_hgt">
@include('slider')
    <div class="top-content">
        <div class="outer-div-sh">
		     <div class="container">
			 <div class="inner-box-sh">
			<div class="page-haeading">
				<h2><strong>Withdraw History</strong></h2>
			</div>			 
			<div class="table-responsive">
				<table id="historytable" class="table table-striped table-bordered display" style="width:100%">
					<thead>
						<tr>
							<th>Id</th>
							<th>To Address</th>
							<th>Amount</th>
							<th>Date</th>
							<th>Hash</th>							
						</tr>
					</thead>
					<tbody>
					@foreach($withdraws as $withdraw)		
						<tr>
							<td>{{$withdraw->id }}</td>
							<td>{{$withdraw->addr}}</td>							
							<td>{{$withdraw->amount}}</td>
							<td>{{$withdraw->created_at}}</td>
							<td>{{$withdraw->tx_hash}}</td>
							
							
						</tr>
					@endforeach
					</tbody>
					<tfoot>
						<tr>
						    <th>Id</th>
							<th>To Address</th>
							<th>Amount</th>
							<th>Date</th>
							<th>Hash</th>	
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
					{{ $withdraws->links() }}						
					</div>
				</div>
			</div>
		</div>
		</div>
		</div>
	</div>
</div>
	</div>
@include('layouts.footer')
@endsection
