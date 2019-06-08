<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\usermasternode;
use App\allmasternode;
use App\Withdraw;
use App\Http\Controllers\HostController;
use App\User;
use App\Usermeta;
use Auth;

use phpseclib\Net\SSH2;
class WithdrawController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');		

    }
	public function Index()
	{
		
		return view('withdraw')->with('user',Auth::user());
	}
   
    public function Withdraw(Request $request)
    {
		$user=Auth::user();
		if ($user->hostingbalance<$request->get('amount')){
			return response()->json(['staus'=>false,'data'=>'Withdraw amount cannot exceed to your balance']);
		}
		$HostController=new HostController;
		$HostController=$HostController->Withdraw(trim($request->get('addr')),trim($request->get('amount')));
		if($HostController['staus']){
			$Withdraw=new Withdraw;
			$Withdraw->user_id=Auth::id();
			$Withdraw->amount=$request->get('amount');
			$Withdraw->addr=trim($request->get('addr'));
			$Withdraw->tx_hash=$HostController['data'];
			$Withdraw->save();
			$user=User::find(Auth::id());
		// $b=	$user->hostingbalance=(float)$user->hostingbalance-(float)trim($request->get('amount'));
		 $b=	$user->hostingbalance=$user->hostingbalance-$request->get('amount');
			$user->save();
			$Usermeta=Usermeta::where('user_id',Auth::id())->first();
			$Usermeta->balance=$b;
			$Usermeta->save();
			
		}
		return response()->json($HostController);
		
    }

    
}
