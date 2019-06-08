<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\usermasternode;
use App\allmasternode;
use App\User;
use App\Usermeta;
use Auth;
use App\deduction;
use App\Withdraw;
use App\Transaction;
use App\Deposit;
class HistoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('auth');
    }
	
	public function Fees()
	{
		$deduction= deduction::where('user_id',Auth::id())->with('masternode')->latest()->paginate(500);		
		//return response()->json($deduction);		
		return view('history.fees')->with('deductions',$deduction);		
	}
	public function Deposit()
	{
		$Transaction= Deposit::where('user_id',Auth::id())->latest()->paginate(500);
		return view('history.deposit')->with('deposits',$Transaction);		
	}
	public function Withdraw()
	{
		$Withdraw= Withdraw::where('user_id',Auth::id())->latest()->paginate(500);
		return view('history.withdraw')->with('withdraws',$Withdraw);		
	}
	
	
}
