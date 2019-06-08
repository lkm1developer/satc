@extends('layouts.layoutpage')
@section('content')
<div class="active-masternode masternode-row m_hgt">
    <div class="top-content">
        <div class="container">
			<div class="page-haeading">
				<h2><strong>Deposit History</strong></h2>
			</div>			 
			<div class="table-responsive">
				<table id="historytable" class="table table-striped table-bordered display" style="width:100%">
					<thead>
						<tr>
							<th>Id</th>
							<th>Amount</th>
							<th>Date</th>
							<th>Hash</th>							
						</tr>
					</thead>
					<tbody>
					@foreach($deposits as $deposit)		
						<tr>
							<td>{{$deposit->id }}</td>
							<td>
							<?php if(!$deposit->amount)	{
								$meta= json_decode($deposit->txid_meta,true);
								//echo gettype($meta);
								if(is_array($meta)){
								 if(array_key_exists('vout',$meta)){
									 foreach($meta['vout'] as $v){
										 if(array_key_exists('addresses',$v['scriptPubKey'])){
											$credit[$v['scriptPubKey']['addresses'][0]]= $v['value'];
										}										
									 }
								}
								//var_dump($credit);die;
								$user =Auth::user();
								//var_dump($user->satoshi_address);die;
								if(array_key_exists(trim($user->satoshi_address),$credit)){
								echo  $credit[trim($user->satoshi_address)];
								}
								}
							}
							else{
								echo $deposit->amount;
							}
							?>
							</td>
							<td>{{$deposit->created_at}}</td>
							<td>{{$deposit->txid}}</td>							
						</tr>
					@endforeach
					</tbody>
					<tfoot>
						<tr>
						    <th>Id</th>
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
					{{ $deposits->links() }}						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	</div>
@include('layouts.footer')
@endsection
