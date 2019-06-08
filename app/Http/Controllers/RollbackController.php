<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Response;
use App\Http\Controllers;
use App\Http\Controllers\SatoshiController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Usermeta;
use App\medic;
use App\port;
use App\IP;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Faker\Factory as Faker;
use App\usermasternode;
use App\allmasternode;
class RollbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');		
    }
	public function Rollback(){
		// var_dump(session()->has('currentNode'));
		if(session()->has('currentNode')){
			if(session('currentNode')){
				$node_id =session('currentNode');
				// var_dump($node_id);
				$node =  Usermasternode ::where('id',$node_id)->first();
				if(count($node)>0){
					$coinid= $node->masternode_id;
					$this->CoinM=$CoinM=Allmasternode::find($coinid);	
					$controller =new  SatoshiController($coinid);
					$this->CoinController=$controller;
					$this->coin=$CoinM->coinnamed;
					$this->coinname=$CoinM->coinname;
					$Delete=$this->CoinController->Delete($node);
					
					if($Delete){
						
						$ck=Transaction::where('txid',$node->tx_hash)->delete();		
					}
					session()->forget('currentNode');
					return response()->json(['status'=>true,'data'=>'Masternode deleted']);
				}
			}
		}
		session()->forget('currentNode');
		return response()->json(['status'=>true,'data'=>'Masternode not exist']);
	}	
	
}
