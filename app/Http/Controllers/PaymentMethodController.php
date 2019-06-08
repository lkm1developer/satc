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
class PaymentMethodController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }
	
	public function PaymentMethod()
    {
		$expiresAt = Carbon::now()->addMinutes(60);
		$coins= allmasternode::where('payment_accepted',true)->get();
		$user =Auth::user();
		$server= Srvr::find(10);
		foreach($coins as $key=>$coin){
			$address= json_decode($user->coins_address,true);	
			if(!is_array($address)){$address=array();}
			if(!array_key_exists($coin->py_name,$address)  && $coin->py_name !=='SATC'){
				$cmd=' cd /home/admin && python create-account.py '.$coin->py_name.' '.$user->email;
				$ssh = new SSH2($server->localhost);			
					if (!$ssh->login($server->ssh_user, $server->ssh_pass)) 
					{	return Redirect::back()->withErrors('Sorry .. Something went wrong !! Please retry');}
				$client_request=$ssh->exec($cmd);
				if($client_request){
				$address[$coin->py_name]=$client_request;	
				}
				
			}			
			$user->coins_address=json_encode($address);
			$user->save();
			if (Cache::has('key')) {
				$coins[$key]->ticker_data=Cache::get('coin'.$coin->py_name);
			} else {
			// if(!Cache::get('coin'.$coin->py_name)){
			//$uri ='https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest?CMC_PRO_API_KEY=0eee1beb-e5fb-4047-ba55-8feb1930a1c9&id='.$coin->tickerId;
			// $uri ='https://api.coingecko.com/api/v3/simple/price?ids='.$coin->tickerId.'&vs_currencies=usd';
			$uri ='http://51.83.73.119:3009/price/'.strtolower($coin->py_name);
			$data=json_decode(file_get_contents($uri),true);
			
			if(is_array($data)){
				$data =(array)$data[0];
				$coinPrice =$data['price'];
			}else {
				return view('othercurrency')->with('error',true);
			}
			Cache::put('coin'.$coin->py_name, $coinPrice, $expiresAt);
			$coins[$key]->ticker_data=Cache::get('coin'.$coin->py_name);
			}
			
		}
		$user= user::find($user->id);
		//return response()->json($coins);
			
		$Setting =  Setting::find(1);
		$satcPrice=$Setting->hosting_rate/$Setting->rate;
		
	 return view('othercurrency')
	 ->with('user',Auth::user())
	 ->with('success',false)->with('coins',$coins)
	 ->with('satc_price',$satcPrice)
	 ->with('final_oc_price','')
	 ->with('error',false)
	 ->with('final_satc_price','')
	 ->with('selected_coin','');;
		
    }
	
	public function PaymentMethodPost()
    {
		//var_dump(Input::all());die;
		if(!Input::get('txid'))
		 { return Redirect::back()->withErrors('Empty Transaction Id');	 }		
		$user=Auth::user();
		$user_id=$user->id;
		$usermeta=Usermeta::where('user_id',$user_id)->first();		 
		$txid=Input::get('txid');
		$amount=Input::get('satc-amount');
        $one_satc=Input::get('satc_price');
		$selected_coin=Input::get('payment_method');
		$frontEndAmount=Input::get('converted');
		$credit=array();
		$server= Srvr::find(10);
		$cmd=' cd /home/admin && python getrawtransaction.py  '.$selected_coin.' '.$txid;
		$ssh = new SSH2($server->localhost);			
		if (!$ssh->login($server->ssh_user, $server->ssh_pass))	{
			return Redirect::back()->withErrors('Sorry .. Something went wrong !! Please retry');
		}			
		$txid_meta=$client_request=$ssh->exec($cmd);
		$client_request=json_decode($client_request,true);
		if(!is_array($client_request)) {
			return Redirect::back()->withErrors('Transaction hash is not valid');
		}
		if(array_key_exists('vout',$client_request)) {
			foreach($client_request['vout'] as $v) {
				if (array_key_exists('addresses',$v['scriptPubKey'])) {
					$credit[$v['scriptPubKey']['addresses'][0]]= $v['value'];
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
                     $correct_value['value']= $value;
                }
			}
			$coins= allmasternode::where('payment_accepted',true)->get();
			foreach($coins as $key=>$coin){
				if($selected_coin== $coin->py_name)
				{
                  $ticker_id=$coin->py_name;
                //   $ticker_id=$coin->tickerId;
				}
			}
			$uri ='http://51.83.73.119:3009/price/'.strtolower($ticker_id);
			$data=json_decode(file_get_contents($uri),true);
			
			if(is_array($data)){
				$data =(array)$data[0];
				$coinPrice =$data['price'];
			}else {
				return view('othercurrency')
				->with('error',true);
			}
			
			
			//$coinPrice= $data->data->1->quotes->USD->price;
			$converted = (1/$one_satc)*($correct_value['value']* $coinPrice);
			$converted_pr = $converted-$converted*.1;
			$con_price=round($converted_pr,4);
			Session::put('con_price', $con_price);
           return view('othercurrency')
		 ->with('user',Auth::user())->with('success','Transaction Id has been verified successfully. Press Add to Balance to add SATC to your account.')->with('coins',$coins)->with('final_oc_price',$correct_value['value'])->with('final_satc_price',$con_price)
		 ->with('selected_coin',$selected_coin)->with('error',false);
		}
				
	}
	public function addBalToOC()
    {
		$user=Auth::user();
		$user_id=$user->id;
		$usermeta=Usermeta::where('user_id',$user_id)->first();		 
	    $txid=Session::get('txhash');
		$amount=Session::get('con_price');
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
		return redirect()->route('othercurrency');
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
	
     public function Notifications($node,$APIdata)
    {
		if($node->last_reward_date<$APIdata->last_paid_date){			
			$arr = [ 'node' => $node,'APIdata' => $APIdata ];
			$user = Auth::user(); 
			$ck=$user->notify(new Reward($arr));
			Usermasternode::where('id',$node->id)->update([
			'last_reward_date'=>$APIdata->last_paid_date
			]);
		}
	}
	public function NodeStatus($node,$APIdata){
		if($node->enabled!=$APIdata->status){			
			$arr = [ 'node' => $node,'APIdata' => $APIdata ];
			$user = Auth::user(); 
			$ck=$user->notify(new Status($arr));
			Usermasternode::where('id',$node->id)->update([
			'enabled'=>$APIdata->status
			]);
		}
	}
	public function MarkAsRead(){
		$user = Auth::user();
		$user->unreadNotifications->markAsRead();
		return redirect()->back();
	}
	public function Sapi(){
		$user = User::find(39);
		//sleep(10)
		return response()->json($user);
		return redirect()->back();
	}
	
}
