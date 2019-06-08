@extends('layouts.admin')

@section('content')
	<div class="container">
		<div class="view-page">
			<div class="container">
				<div class="inner-page-title">
                    <h2><strong>Masternode </strong> Detail</h2>
                    
				</div>
				
				<div class="detail-section table-responsive"><p>{{$user->name}}
					</p><p>{{$user->email}}
					</p>
<table class="table" id="myTable">
    <tbody>
        <tr>
          <th class=" horizontal-head"></th>
            <th class=" horizontal-head">Masternode</th>
            <th class=" horizontal-head">Detail</th>

        </tr>
        <tr>
          <th class="bg-secondary vertical-head"><i class="fa fa-id-card"></i></th>
            <td class="bg-white">Id</td>
            <td class="node-odd">{{$usermasternode->id}}</td>
            
        </tr>
        <tr>
         
             <th  class="bg-secondary vertical-head"><i class="fa fa-id-card"></i></th>
            <td class="bg-white">Blockchain</td>
            <td class="node-evn">{{$usermasternode->masternode->name}}</td>
        </tr>
        <tr>
          <th  class="bg-secondary vertical-head"><i class="fa fa-id-card"></i></th>
            <td class="bg-white">Ip</td>
            <td class="node-odd">{{$usermasternode->ip}}</td>
        </tr>
		
		 <tr>
          <th  class="node-odd vertical-head"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></th>
            <td class="node-odd">IP</td>
            <td class="node-odd">{{$usermasternode->ip}}:{{$usermasternode->port}}</td>
        </tr>
		
		<tr>
          <th class="node-evn vertical-head"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></th>
            <td class="node-evn">Created date</td>
            <td class="node-evn"> {{ $usermasternode->created_at->format('d /M /Y - H:i:s') }}</td>
        </tr>
		
		<tr>
          <th  class="node-odd vertical-head"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></th>
            <td class="node-odd"> Status</td>
            <td class="node-odd">
			<button coin="{{ $usermasternode->masternode_id}}" id="{{ $usermasternode->id}}"class="btn btn-primary checkstatus">Check</button></td>
        </tr>
			
		<tr>
          <th class="node-evn vertical-head"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></th>
            <td class="node-evn">Private Key</td>
            <td class="node-evn">{{ $usermasternode->private_key}} </td>
        </tr><tr>
          <th class="node-evn vertical-head"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></th>
           
            <td class="node-evn"><button class="btn btn-danger deletemasternode" 
			id="{{$usermasternode->id}}" coin="{{$usermasternode->masternode_id}}">Delete</button> </td>
			 <td class="node-evn"></td>
        </tr>
    </tbody>
</table>
			</div>
			

		</div>
	</div>
</div>
</div>


	
	
@endsection