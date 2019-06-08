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
use App\Reward as RewardDB;
use App\Allreward;
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
class NotificationController extends Controller
{
    public function __construct($console=null)
    {
		if(!$console){
			//$this->middleware('auth');
		}
    }
	
	public function unreadNotifications($coin=null)
    {
		$expiresAt = Carbon::now()->addMinutes(60);
		$coins= allmasternode::where('payment_accepted',true)->get();
		$user =Auth::user();
		$server= Srvr::find(10);
		foreach($coins as $key=>$coin){
			$address= json_decode($user->coins_address,true);
			if(!is_array($address)){$address=array();}
			if(!array_key_exists($coin->py_name,$address)  && $coin->py_name !=='SATC'){
				//generate addres: python create-account.py coin symbole username
				$cmd=' cd /home/admin && python create-account.py '.$coin->py_name.' '.$user->email;
				$ssh = new SSH2($server->localhost);			
					if (!$ssh->login($server->ssh_user, $server->ssh_pass)) 
					{	return Redirect::back()->withErrors('Sorry .. Something went wrong !! Please retry');}
				$client_request=$ssh->exec($cmd);
				if($client_request){
				$address[$coin->py_name]=$client_request;	
				}
				
			}
			else{
				$address['SATC']=$user->satoshi_address;	
			}
			$user->coins_address=json_encode($address);
			$user->save();
			if($coin->py_name== 'SATC'){
				if(!Cache::get('coin'.$coin->py_name)){
					$Setting =  Setting::find(1);
					$coinPrice=$Setting->hosting_rate/$Setting->rate;	
					//var_dump($coinPrice);die;					
				Cache::put('coin'.$coin->py_name, $coinPrice, $expiresAt);
				}
				$coins[$key]->ticker_data=Cache::get('coin'.$coin->py_name);
			} else {
					if(!Cache::get('coin'.$coin->py_name)){
					// $data=json_decode(file_get_contents('https://api.coinmarketcap.com/v2/ticker/'.$coin->tickerId));	
				//	$data=json_decode(file_get_contents('https://api.coingecko.com/api/v3/simple/price?ids='.$coin->tickerId.'&vs_currencies=usd'));	
					$uri ='https://api.coingecko.com/api/v3/simple/price?ids='.$coin->tickerId.'&vs_currencies=usd';
					$data=json_decode(file_get_contents($uri));
					$data =(array)$data;
					$data =$data[$coin->tickerId];
					$coinPrice =$data->usd;
					Cache::put('coin'.$coin->py_name, $coinPrice, $expiresAt);
					}
					$coins[$key]->ticker_data=Cache::get('coin'.$coin->py_name);
			}
		}
		$user= user::find($user->id);
		//return response()->json($coins);
	 return view('notify')
		 ->with('user',Auth::user())->with('success',false)->with('coins',$coins);
		
    }
	
	public function PostHosting()
    {
		if(!Input::get('txid'))
		 { return Redirect::back()->withErrors('Empty Transaction Id');	 }		
		$user=Auth::user();
		$user_id=$user->id;
		$usermeta=Usermeta::where('user_id',$user_id)->first();		 
		$txid=Input::get('txid');
		$amount=Input::get('satc-amount');
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
		//return response()->json($credit);
		if(is_array($add) && array_key_exists($selected_coin,$add)) {
			if(!array_key_exists(trim($add[$selected_coin]),$credit)) {
				 return Redirect::back()->withErrors('Transaction Id not related to your Address');
			}
		} else {
			 return Redirect::back()->withErrors('your Address not valid');
		}
		
		$newuser= User::FindOrFail($user->id);
		$Usermeta= Usermeta::where('user_id',$user->id)->first();
		if($selected_coin=='SATC'){
			$transactionHash=$txid; 
			$valid_Txid=Deposit::where('txid',$txid)->first();
			if($valid_Txid){
				return Redirect::back()->withErrors('Transaction Id Already used');
			}
			$satcToAdd = $credit[trim($user->satoshi_address)];
		} else {
			$transactionHash=$selected_coin.'-'.$txid; 
			$valid_Txid=Deposit::where('txid',$transactionHash)->first();
			if($valid_Txid){
				return Redirect::back()->withErrors('Transaction Id Already used');
			}
			$toDeposit = $credit[trim($add[$selected_coin])];
			$satcToAdd = $this->Fraud($selected_coin, $toDeposit);
			$toDeposit = $satcToAdd;
			// if($amount== $satcToAdd) {
				// $toDeposit=$amount;
			// } else {
				// return Redirect::back()->withErrors('invalid Amount');
			// }  
		}
		
		// $Usermeta->balance=$Usermeta->balance+$toDeposit; 
		// $Usermeta->save(); 
		 // $newuser->hostingbalance=$newuser->hostingbalance+$toDeposit; 
		 // $newuser->crypto_id='m';
		 // $newuser->save();
		  $new_transactions=new Deposit;
		  $new_transactions->user_id=$user->id;
		  $new_transactions->txid=$transactionHash;
		  $new_transactions->amount=$toDeposit;
		  $new_transactions->used=true;
		  $new_transactions->txid_meta=$txid_meta;
		  $new_transactions->save(); 
		 
		 
		 //$response = $client_request->getBody();
		 //print_r($response);
		// die();
		 
		  // $success ='Added '.$toDeposit .'Credits'; 
		    $success ='Added '.$toDeposit.' SATC';
		   Session::flash('message', $success);
		$user= User::FindOrFail($user->id);
		return redirect()->route('testting');
		 return View("hosting")->with(array('user'=>$user,'usermeta'=>$usermeta,'credit'=>$toDeposit,'success'=>$success));
								
	}
	
	public  function Fraud($selectdCoin, $apiAmount){
		$selectedCoinPrice = Cache::get('coin'.$selectdCoin);
		//var_dump($selectedCoinPrice);
		$satcPrice =Cache::get('coinSATC');
		//var_dump($satcPrice);
		if(!$satcPrice || ! $selectedCoinPrice){
			Session::flash('message', 'Last Transaction failed please retry ');
			return redirect()->route('testting');
		}
			
		$grandTotal =$selectedCoinPrice *$apiAmount;
		//var_dump($grandTotal);
		$myCut= ($grandTotal * (1/11));
		//var_dump($myCut);
		$toTransfer =$grandTotal - $myCut;
		//var_dump($toTransfer);
		$canBuySatcByGrandTotal= round(($toTransfer/$satcPrice),6);
		//var_dump($canBuySatcByGrandTotal);
		 return round($canBuySatcByGrandTotal,6);
		 //die;
		
	}
	public function Reward ($masternode,$paid){
		$hasRecord = RewardDB::where('usermasternode_id',$masternode->id)->first();
		if(count($hasRecord)==0) {
			$newReward = new RewardDB;
			$allnewReward= new Allreward;
			$allnewReward->usermasternode_id=$newReward->usermasternode_id = $masternode->id;
			$allnewReward->allmasternode_id=$newReward->allmasternode_id =  $masternode->masternode_id;
			$allnewReward->user_id=$newReward->user_id = $masternode->user_id;
			$allnewReward->amount=$newReward->amount = $paid->last_paid_amount;
			$allnewReward->date=$newReward->date = $paid->last_paid_date;
			$allnewReward->updated=$newReward->updated = $paid->last_update;
			$allnewReward->save();
			$newReward->save();
			return true;			
		} else {
			if($hasRecord->date< $paid->last_paid_date){
				$newReward =  RewardDB::find($hasRecord->id);
				$newReward->amount = $hasRecord->amount+$paid->last_paid_amount;
				$newReward->date = $paid->last_paid_date;
				$newReward->updated = $paid->last_update;
				$newReward->save();
				$allnewReward= new Allreward;
				$allnewReward->usermasternode_id=$masternode->id;
				$allnewReward->allmasternode_id=  $masternode->masternode_id;
				$allnewReward->user_id= $masternode->user_id;
				$allnewReward->amount= $paid->last_paid_amount;
				$allnewReward->date=$paid->last_paid_date;
				$allnewReward->updated= $paid->last_update;
				$allnewReward->save();
				return true;			
			}
			return true;
		}
	}
     public function Notifications($node,$APIdata,$user_id=null)
    {
		if($node->last_reward_date<$APIdata->last_paid_date){			
			$arr = [ 'node' => $node,'APIdata' => $APIdata,'user_id'=>$user_id ];
			if($user_id){
				$user= User::find($user_id);
			}
			else {
			$user = Auth::user(); 
			}
			if(count($user)>0){
				$ck=$user->notify(new Reward($arr));
				Usermasternode::where('id',$node->id)->update([
				'last_reward_date'=>$APIdata->last_paid_date
				]);
				$this->Reward ($node,$APIdata);
			}
		}
	}
	public function NodeStatus($node,$APIdata,$user_id=null){
		if($node->enabled!=$APIdata->status){			
			$arr = [ 'node' => $node,'APIdata' => $APIdata,'user_id'=>$user_id ];
			if($user_id){
				$user= User::find($user_id);
			}
			else {
			$user = Auth::user(); 
			} 
			if(count($user)>0){
				$ck=$user->notify(new Status($arr));
				Usermasternode::where('id',$node->id)->update([
				'enabled'=>$APIdata->status
				]);
			}
		}
	}
	public function MarkAsRead(){
		$user = Auth::user();
		$user->unreadNotifications->markAsRead();
		return redirect()->back();
	}
	public function Sapi(){
		$d=User::find(39);
		//sleep(10)
		
		$headers = [
			"Access-Control-Allow-Origin"=>"*",
			'Access-Control-Allow-Methods'=> 'GET, POST, PUT, PATCH, DELETE, OPTIONS',
			'Access-Control-Allow-Headers'=> 'Content-Type, Authorizations',
        ];
		return response()->json(['success'=>true,'data'=>'$d'],200, $headers);
		//return redirect()->back();
	}
	
}
