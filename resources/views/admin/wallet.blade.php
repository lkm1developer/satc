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
              <a href="{{url('/admin/coins/')}}">Coins</a>
            </li>
            <li class="breadcrumb-item active">Overview</li>
          </ol>

          <!-- Icon Cards-->
       
		
          <!-- DataTables Example -->
          <div class="card mb-3">
            
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
						<th>ID</th>
						<th>Name</th>
						<th>Balance</th>
						<th>Refresh Bal</th>
						<th>Passphrase</th>
						<th>Time</th>
						<th>Address</th>
						<th>Amount</th>
						<th>Send</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>                    
						<th>ID</th>
						<th>Name</th>
						<th>Balance</th>
						<th>Refresh Bal</th>
						<th>Passphrase</th>
						<th>Time</th>
						<th>Address</th>
						<th>Amount</th>
						<th>Send</th>
                    </tr>
                  </tfoot>
                  <tbody>
                   @foreach($coins as $coin)
					<tr>
						
						<td>{{$coin->id }}</td>
						<td><img class="smalllogo"style="max-width:50px;" 
						src="{{url('/public').'/'.$coin->logo}}">{{$coin->name }}</td>
						<td id="bal{{$coin->py_name}}">{{$coin->balance}}</td>						
						<td><button id="bal{{$coin->py_name}}" class="refresh_bal" lkm="{{$coin->py_name}}"><i class="fa fa-refresh"></i></button></td>						

						<td><input type="text" name="pass" class="coin-pass"id="pass{{$coin->py_name}}"/></td>
						<td><input type="text" name="time" class="coin-time"id="time{{$coin->py_name}}"/></td>

						<td ><input type="text" name="address" class="coin-address"id="address{{$coin->py_name}}" value="{{$coin->wallet_address}}"/></td>
						<td><input type="text" name="amount" class="coin-amount"id="amount{{$coin->py_name}}"/></td>
						<td><button class="send_bal" id="{{$coin->py_name}}"><i class="fas fa-exchange-alt"></i></button>
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