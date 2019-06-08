@extends('layouts.layoutpage')

@section('content')
@include('slider')
	<div class="outer-div-sh">	
		<div class="container">	
			<div class="inner-box-sh">		
		<!---View detail page-->
		<div class="view-page m_hgt view-page-inner">
			<div class="container">
				<div class="page-haeading">
                    <h2><strong>{{$usermasternode->masternode->masternode }}</strong> Information</h2>
                  <input type="hidden"id="masternode_dynamic"  value="{{$usermasternode->masternode->masternode }}"/>
				</div>
				
				<div class="detail-section table-responsive">
<table class="table" id="myTable">
    <tbody>
        <tr>
          <th class="bg-dark horizontal-head"></th>
            <th class="bg-dark horizontal-head">{{$usermasternode->masternode->masternode }}</th>
            <th class="bg-dark horizontal-head">Detail</th>

        </tr>
        <tr>
          <th class="node-odd vertical-head"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></th>
            <td class="node-odd">Id</td>
            <td class="node-odd">{{$usermasternode->id}}</td>
            
        </tr>
        <tr>
         
             <th  class="node-evn vertical-head"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></th>
            <td class="node-evn">Coin</td>
            <td class="node-evn"><img style="max-height:30px;"class="trimg"src="/public/{{$usermasternode->masternode->logo }}"/>{{$usermasternode->masternode->name}}</td>
        </tr>
		<tr>
          <th  class="node-odd vertical-head"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></th>
            <td class="node-odd"> Status</td>
            <td class="node-odd">
			<button coin="{{ $usermasternode->masternode_id}}" id="{{ $usermasternode->id}}"class="btn btn-primary checkstatus" >Check</button></td>
        </tr>
       
		<tr>
          <th class="node-evn vertical-head"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></th>
            <td class="node-evn">Created date</td>
            <td class="node-evn"> {{ $usermasternode->created_at->format('d /M /Y - H:i:s') }}</td>
        </tr>
		
		 <tr>
          <th  class="node-odd vertical-head"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></th>
            <td class="node-odd">IP</td>
            <td class="node-odd"><span id="copyipport">{{$usermasternode->ip}}:{{$usermasternode->port}}</span><button style="float:right;"class="copy-button fa fa-copy" data-clipboard-action="copy" data-clipboard-target="#copyipport">Copy</button></td>
        </tr>
		
			
		<tr>
          <th class="node-evn vertical-head"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></th>
            <td class="node-evn">{{$usermasternode->masternode->masternode }} Private Key</td>
            <td class="node-evn"><span id="prvky">{{ $usermasternode->private_key}}</span><button style="float:right;"class="copy-button fa fa-copy" data-clipboard-action="copy" data-clipboard-target="#prvky">Copy</button></td>
        </tr>
		
		<tr>
          <th class="node-odd vertical-head"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></th>
            <td class="node-odd">TxHash</td>
            <td class="node-odd"><span id="txhsh">{{ $usermasternode->tx_hash}}</span>
			<button style="float:right;"class="copy-button fa fa-copy" data-clipboard-action="copy" data-clipboard-target="#txhsh">Copy</button></td>
        </tr>
		
		<tr>
          <th class="node-evn vertical-head"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></th>
            <td class="node-evn">PubKey</td>
			<?php //var_dump($usermasternode);?>
			@if($usermasternode->wallet_addr)
				 <td class="node-evn">{{ $usermasternode->wallet_addr??''}} </td>
			 @else
            <td class="node-evn">{{ $found->addr??''}} </td>
		@endif
        </tr>
        <tr>
          <th  class="node-odd vertical-head"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></th>
            <td class="node-odd"> Wallet Info</td>
            <td class="node-odd">
			<button coin="{{ $usermasternode->masternode_id}}" id="{{ $usermasternode->id}}"class="btn btn-primary walletinfo" >Check</button></td>
        </tr>
		<tr>
          <th class="node-odd vertical-head"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></th>
            <td class="node-odd">Wallet Sync</td>
			@if(isset($found->status_wallet_synced))
				<td style="color:green;"class="node-odd">Synced</td>
			@else
				<td style="color:red;"class="node-odd">Not Synced</td>
			@endif
			</td>
		
        </tr>
		
		<tr>
          <th class="node-evn vertical-head"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></th>
            <td class="node-evn">Active Time</td>
            <td class="node-evn"> {{ $found->active_time??''}}</td>
        </tr>
		
		<tr>
          <th class="node-odd vertical-head"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></th>
            <td class="node-odd">Last Seen</td>
            <td class="node-odd"> {{ $found->last_seen??''}}</td>
        </tr>
		
		<tr>
          <th class="node-evn vertical-head"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></th>
            <td class="node-evn">Last Reward Date</td>
            <td class="node-evn"> 
			@if(isset($foundpaid->last_paid_date))
			{{ $foundpaid?date('Y-m-d h:s:iA',$foundpaid->last_paid_date??''):''}}</td>
			@endif
        </tr>
		<tr>
          <th class="node-odd vertical-head"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></th>
            <td class="node-odd">Last Reward amount</td>
            <td class="node-odd"> 
			@if(isset($foundpaid->last_paid_amount))
			{{ $foundpaid->last_paid_amount??''}}
			@endif
			@if(isset($foundpaid->last_paid_amount))
			@if($price)
				
			{{$usermasternode->masternode->py_name }} / 
			${{$foundpaid->last_paid_amount*$price[0]->usd_value}}
			@endif
			@endif
			</td>
        </tr>
		<tr>

          <th class="node-evn vertical-head"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></th>
            <td class="node-evn">Total Reward amount</td>
            
            <td class="node-evn">
			<?php	//var_dump(($reward));?>		
				@if(isset($reward->amount))
				{{ $reward->amount}}
				@if(count($price) >0)
					{{$usermasternode->masternode->py_name }} /  ${{$reward->amount*$price[0]->usd_value}}
				@endif
				@endif
			
			</td>
            
			
        </tr>
		
		<!--<tr>
          <th class="node-odd vertical-head"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></th>
            <td class="node-odd"> Reward History</td>
            <td class="node-odd"> 
			@if($reward)
				<a href="{{url('home/view/'.$usermasternode->id.'/reward')}}"><button class="btn btn-primary"></button></a>
			
			@endif
			</td>
        </tr>-->
		
	
		
		
		
    </tbody>
</table>
			</div>
			
			<div class="back-delete">
				<a href="{{url('/moniter')}}">Back</a>
				<button style="float:right;"class="btn btn-danger deletemasternode" 
			id="{{$usermasternode->id}}" coin="{{$usermasternode->masternode_id}}">Delete</button>
			</div>
			
		</div>
	</div>
</div>
</div>
</div>
	<style>
	.hhh {
    font-size: 11px;
}
	</style>
		
		<!---End View detail page-->
			
	
	@include('layouts.footer')
@endsection