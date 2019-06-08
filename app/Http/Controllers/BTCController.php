<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\usermasternode;
use App\allmasternode;
use App\User;
use App\Usermeta;
use Auth;
//use GuzzleHttp\Client;
use App\IP;
use App\Apihosted;
use App\Apiinfo;
use App\Srvr;
use App\Setting;
use Artisan;
use DB;
use App\Deposit;
use Redirect;
use Session;
use Illuminate\Support\Facades\Input;
use phpseclib\Net\SSH2;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\SatoshiController;
use App\Http\Controllers\Auth\BlockchainController;
use App\Notifications\Reward;
use App\Notifications\Status;
use View;
use Log;
class BTCController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
	   $satc_pricedata=json_decode(file_get_contents('https://graviex.net//api/v2/tickers/satcbtc.json'));	
		$this->satcPrice= $satc_pricedata->ticker->last;
		$data=json_decode(file_get_contents('https://api.coinbase.com/v2/prices/spot?currency=USD'));	
		$this->btcPrice= $data->data->amount;
    }
	
	public function PaymentMethod()
    {
		$expiresAt = Carbon::now()->addMinutes(60);
		$coins= allmasternode::where('py_name','BTC')->get();
		$user =Auth::user();
		$server= Srvr::find(10);
		foreach($coins as $key=>$coin){
			$address= json_decode($user->coins_address,true);	
			if(!is_array($address)){$address=array();}
			if(!array_key_exists($coin->py_name,$address)  && $coin->py_name !=='SATC'){
				//$cmd=' cd /home/docker-wallets && python create-account.py '.$coin->py_name.' '.$user->email;
				$cmd=' cd /home/admin && python create-account.py '.$coin->py_name.' '.$user->email;
				$ssh = new SSH2('192.168.0.200');			
					if (!$ssh->login($server->ssh_user, $server->ssh_pass)) 
					{	return Redirect::back()->withErrors('Sorry .. Something went wrong !! Please retry');}
				$client_request=$ssh->exec($cmd);
				if($client_request){
				$address[$coin->py_name]=$client_request;	
				}
				
			}			
			$user->coins_address=json_encode($address);
			$user->save();
			
			//if(!Cache::get('coin'.$coin->py_name)){
			
			// Cache::put('coin'.$coin->py_name, $coinPrice, $expiresAt);
			// }
			$coins[$key]->ticker_data=Cache::get('coin'.$coin->py_name);
			
		}
		$user= user::find($user->id);
		//return response()->json($coins);
			
		
	 return view('btccurrency')
	 ->with('user',Auth::user())->with('success',false)->with('coins',$coins)
	 ->with('satc_price',$this->satcPrice)->with('final_oc_price','')->with('final_satc_price','');
		
    }
	
	public function PaymentMethodPost()
    {
		if(!Input::get('txid'))
		 { return Redirect::back()->withErrors('Empty Transaction Id');	 }		
		$user=Auth::user();
		$user_id=$user->id;
		$usermeta=Usermeta::where('user_id',$user_id)->first();		 
		$txid=Input::get('txid');
		$amount=Input::get('satc-amount');
        //$one_satc=Input::get('satc_price');
        $one_satc=$this->satcPrice;
		$selected_coin="BTC";
		$frontEndAmount=Input::get('converted');
		$credit=array();
		$server= Srvr::find(10);
		//$cmd=' cd /home/docker-wallets && python getrawtransaction.py  BTC '.$txid;
		$cmd=' cd /home/admin && python getrawtransaction.py  BTC '.$txid;
		$ssh = new SSH2('192.168.0.200');			
		if (!$ssh->login($server->ssh_user, $server->ssh_pass))	{
			return Redirect::back()->withErrors('Sorry .. Something went wrong !! Please retry');
		}			
		$txid_meta=$client_request=$ssh->exec($cmd);
		$client_request=json_decode($client_request,true);
		Log::info('btc verification  '.$cmd.'  '.$txid_meta);
		if(!is_array($client_request)) {
			return Redirect::back()->withErrors('Transaction hash is not valid');
		}
		// if(array_key_exists('vout',$client_request)) {
			// foreach($client_request['vout'] as $v) {
				// if (array_key_exists('addresses',$v['scriptPubKey'])) {
					// $credit[$v['scriptPubKey']['addresses'][0]]= $v['value'];
				// }				
			// }
		// }
		if(array_key_exists('outputs',$client_request)) {
			foreach($client_request['outputs'] as $v) {
				if (array_key_exists('address',$v)) {
				// if(in_array(trim($address->address), $v)) {
					$credit[$v['address']]= $v['value'];
				}				
			}
		}
		
		$add= json_decode($user->coins_address,true);
		if(is_array($add) && array_key_exists($selected_coin,$add)) {
			if(!array_key_exists(trim($add[$selected_coin]),$credit)) {
                
				 return Redirect::back()->withErrors('Transaction Id is not related to your Address');
			}
		} else {
			 return Redirect::back()->withErrors('your Address is not valid');
		}
		
		$newuser= User::FindOrFail($user->id);
		$Usermeta= Usermeta::where('user_id',$user->id)->first();
		if($selected_coin=='SATC'){
			$transactionHash=$txid; 
			$valid_Txid=Deposit::where('txid',$txid)->first();
			if($valid_Txid){
				return Redirect::back()->withErrors('Transaction Id has been Already used');
			}
			$satcToAdd = $credit[trim($user->satoshi_address)];
		} else {
			$transactionHash=$selected_coin.'-'.$txid; 
			$valid_Txid=Deposit::where('txid',$transactionHash)->first();
			if($valid_Txid){
				return Redirect::back()->withErrors('Transaction Id has already been used.');
			}
			Session::put('txhash', $transactionHash);
			$correct_value=array();
			foreach($credit as $key=>$value)
			{
                if($key == trim($add[$selected_coin]))
                {
                     $correct_value['address']= $key;
                     $correct_value['value']= $value/100000000;
                }
			}
			
			
			$converted =($correct_value['value']/ $one_satc);
			$converted_pr = $converted-$converted*.2;
			$con_price=round($converted_pr,9);
			Session::put('con_price', $con_price); //found satc in this transaction after conversion
			$coins= allmasternode::where('py_name','BTC')->get();
           return view('btccurrency')
		 ->with('user',Auth::user())->with('success','Transaction Id has been verified successfully.')->
		 with('coins',$coins)->with('final_oc_price',$correct_value['value'])
		 ->with('final_satc_price',$con_price)->with('satc_price',$this->satcPrice);
		}
				
	}
	public function addBalToOC()
    {
		$user=Auth::user();
		$user_id=$user->id;
		$usermeta=Usermeta::where('user_id',$user_id)->first();		 
	    $txid=Session::get('txhash');
		$amount=Session::get('con_price');;
		//$amount=Input::get('last_satc_value');
		$selected_coin=Input::get('curren_coin');
		$frontEndAmount=Input::get('last_oc_value');
		$credit=array();
		$newuser= User::FindOrFail($user->id);
		$Usermeta= Usermeta::where('user_id',$user->id)->first();
		$transactionHash=$txid; 
		$valid_Txid=Deposit::where('txid',$transactionHash)->first();
			if($valid_Txid){
				return Redirect::back()->withErrors('Transaction Id has already been used.');
			}
		$Usermeta->balance=$Usermeta->balance+$amount; 
		$Usermeta->save(); 
		//$newuser->hostingbalance=$newuser->hostingbalance+$amount; 
		//$newuser->crypto_id='m';
		//$newuser->save();
		$new_transactions=new Deposit;
		$new_transactions->user_id=$user->id;
		$new_transactions->txid=$transactionHash;
		$new_transactions->amount=$amount;
		$new_transactions->used=true;
		$new_transactions->txid_meta='';
		$new_transactions->save();  
		    $success ='Deposited '.$amount.' SATC successfully';
		   Session::flash('message', $success);
		$user= User::FindOrFail($user->id);
		return redirect()->route('btccurrency');
		 //return View("hosting")->with(array('user'=>$user,'usermeta'=>$usermeta,'credit'=>$toDeposit,'success'=>$success));
								
	}
	
	public  function Fraud($selectdCoin, $apiAmount){
		$selectedCoinPrice = Cache::get('coin'.$selectdCoin);
		$satcPrice =Cache::get('coinSATC');
		if(!$satcPrice || ! $selectedCoinPrice){
			Session::flash('message', 'Last Transaction failed please retry ');
			return '0';
		}
		$grandTotal =$selectedCoinPrice *$apiAmount;
		//var_dump($grandTotal);
		$myCut= ($grandTotal * (1/11));
		//var_dump($myCut);
		$toTransfer =$grandTotal - $myCut;
		//var_dump($toTransfer);
		$canBuySatcByGrandTotal= round(($toTransfer/$satcPrice),4);
		//var_dump($canBuySatcByGrandTotal);
		 return round($canBuySatcByGrandTotal,4);
		 //die;
		
	}
	
    
}
