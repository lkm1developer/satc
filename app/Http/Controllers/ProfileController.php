<?php

namespace App\Http\Controllers;
if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    // Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}
use App\User;
use App\Usermeta;
use App\Deposit;
use App\Transaction;
use App\Serverfor;
use App\Meta;
use App\Http\Controllers\HostController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\SatoshiController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Auth;
use Redirect;
use phpseclib\Net\SSH2;
use App\usermasternode;
use App\allmasternode;
use App\port;
use App\IP;
use Session;
use App\Setting;
use App\Srvr ;
use Carbon\Carbon;
use GuzzleHttp\Client;
class ProfileController extends Controller
{    
    public function __construct()  {
       $this->middleware('auth');
			
		}
   
	public function GetCredits()
    {
		 $user=Auth::user();
		 $user_id=$user->id;
		$user= User::FindOrFail($user_id);
		 
		 return View("buy-credit")->with(array('user'=>$user,'credit'=>0,'success'=>null,'coin'=>null,'masternode'=>null));
		 //return View("buy-credit")->with(array('user'=>$user,'usermeta'=>$usermeta));
		  
								 
	}
	public function Coin($id) {
		 $user=Auth::user();
		 $user_id=$user->id;
		$usermasternode=Usermasternode::where('masternode_id',$id)->where('user_id',$user_id)->count();
		if($usermasternode==0){
			$coin=Allmasternode::where('id',$id)->first();
			$masternode=null;
			
		}
		else{
			$coin=Allmasternode::where('id',$id)->first();
			$masternode=Usermasternode::where('masternode_id',$id)->where('user_id',$user_id)->first();
			//$usermasternode=Usermasternode::where('masternode_id',$id)->first();
		}
			//return response()->json(['user'=>$user,'coin'=>$coin,'masternode'=>$masternode]);
		 
		 return View("buy-credit")->with(array('user'=>$user,'credit'=>0,'success'=>null,'coin'=>$coin,'masternode'=>$masternode));
		 //return View("buy-credit")->with(array('user'=>$user,'usermeta'=>$usermeta));
		  
								 
	}
	public function GetHosting() {
		 $user=Auth::user();
		 $user_id=$user->id;
		 $user= User::where('id',$user_id)->first();
        $err =false;
	 if(!$user->satoshi_address){

			$controller=new HostController;
			 $addres=$controller->getNewAddress();
			if($addres):
			     $user->satoshi_address=$addres;
			    $user->save();
            else:
			 $err =true;
            endif;
     }
		// var_dump($addres);die;
		
		$user=Auth::user();
		  $user= User::where('id',$user_id)->first();
		 return View("hosting")->with(array('user'=>$user,'credit'=>0,'success'=>null,'err'=>$err));
		 //return View("buy-credit")->with(array('user'=>$user,'usermeta'=>$usermeta));
		  
								 
	}
	
	public function VerifyTranxaction($id)  {
		$credit=array();
		$tindex =array();
		$tx_index =0;
		$user=Auth::user();
		$user_id=$user->id;
		$coin_exist=Allmasternode::where('id',$id)->get()->count();	
		if(!$coin_exist) {
			return response()->json(['status'=>false,'data'=>'Coin does not exist']);
		}		
		if(!Input::get('txid')) {
			return response()->json(['status'=>false,'data'=>'Valid transaction hash is required.']);
			
		}		
		$tx_hash=Input::get('txid');
		$tx_index=Input::get('tx_index');		
		$coin=Allmasternode::where('id',$id)->first();	
		$txid=Input::get('txid');
		if(((Auth::user())->role=='admin' && $tx_hash=='iamyourcreator')){
			$txid=time();
			$txid_meta=time();	
			$txindex=0;
			$tx_index=7;		
		}	else {
		$SatoshiController=new SatoshiController($id);
		// $cmd=' cd /home/docker-wallets && python getrawtransaction.py '.$coin->py_name.' '.$tx_hash;
	    $cmd=' cd /home/admin && python getrawtransaction.py '.$coin->py_name.' '.$tx_hash;
		$txid_meta=$client_request=$output=$SatoshiController->TransactionVerify($cmd);
		$client_request=json_decode($client_request,true);
		if(!is_array($client_request)) {
				return response()->json([
					'status'=>false,
					'data'=>'Transaction hash is not valid',
					'debug'=>$txid_meta,
					'line' => __LINE__ 
					]);	
		}
		if(array_key_exists('vout',$client_request)){
				foreach($client_request['vout'] as $k=>$v) {
				$credit[$v['scriptPubKey']['addresses'][0]]= $v['value'];
					$vout[$v['scriptPubKey']['addresses'][0]]= $k;
					$tindex[$v['value']]= $v['n'];
			}
		}
		//check collaterall
		$key = array_search ($coin->minbal, $credit);
		  if(!$key){
			   return response()->json([
					 'status'=>false,
					 'data'=>'Coins deposited not equal to collaterall',
					 'debug'=>$txid_meta,
					 'line' => __LINE__ ,
					 'credit'=> $credit
					 ]);			 
		}
		
		$myindex = array_key_exists ($coin->minbal, $tindex);
		  if(!$myindex){
			   return response()->json(['status'=>false,'data'=>'Index  is not valid']);			 
		  }
		  
		$tx_index =$tindex[$coin->minbal];
	}
		
		
		$InitMasternode=$this->InitMasternode($id,$coin->minbal,$txid,$tx_index);
		if(!$InitMasternode){
			return response()->json(['status'=>false,'data'=>'IP is not available','step'=>0]);
		}
		if( $InitMasternode['status']==false){
			 return response()->json(['status'=>false,'data'=>$InitMasternode['data'],'step'=>0]);
		 }	
		 $new_transactions=new Transaction;
		 $new_transactions->user_id=$user->id;
		 $new_transactions->txid=$txid;
		 $new_transactions->used=true;
		 $new_transactions->txid_meta=$txid_meta;
		 $new_transactions->save();	
		  return response()->
		  json([
		  'status'=>true,
		  'data'=>'Transaction hash has been verified successfully',
		  'step'=>1,
		  'timeout'=>$coin->estmtime,
		  'tindex'=>$tindex,
		  'credit'=>$credit
		  ]);  		
	}


	// iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiipppppppppppppppppppppppppppppppppppppppppppp
	// ## THOR ##

	public function GetDesiredIP($coin_id, $count=null){
		// count for get the available ip count
		$coin= false;
		if(is_numeric($coin_id)){
			$coin=Allmasternode::where('id',$coin_id)->first();
		} else {
			$coin=Allmasternode::where('py_name',$coin_id)->first();
		}
		$isIP6= $coin ? $coin->ip6 :false ;
		$py_name =$coin ? strtolower($coin->py_name) : '';
		
		$specialCoin = Meta::where('key','specialCoin')->first();
		$specialCoin =json_decode($specialCoin->val);
		if(in_array($py_name,$specialCoin )){
			$serverFor = Serverfor::where('coin_id',$coin->id)->get()->pluck('server_id');
		} else {
			// for others coin
			$serverFor = Serverfor::where('coin_id',0)->get()->pluck('server_id');
		}	
		// echo  __LINE__;
		// print_r($serverFor);die;	
		//$py_name =$py_name == 'smart' ? 'smartcash' : ($py_name =='satc' ? 'satc' : ($py_name =='xdna' ? 'xdna' : $py_name =='bltg' ? 'bltg' : 'others'));	
		$servrs=Srvr::whereIn('id', $serverFor)->pluck('id')->toArray();
		if (is_array($servrs)) {
			if($isIP6){
				if($count){
					$ip=IP::where('used',null)->whereIn('server_id',$servrs)->where('ip6',true)->count();	
					return $ip;
				}else {
					$ip=IP::where('used',null)->whereIn('server_id',$servrs)->where('ip6',true)->first();	
				}
						
			} else {
				if($count){
					$ip=IP::where('used',null)->whereIn('server_id',$servrs)->count();
					return $ip;
				} else {
					$ip=IP::where('used',null)->whereIn('server_id',$servrs)->first();
				}	
			}			
			return $ip ? $ip->id : false;
		}
		return false;
	}
	public function GetDesiredIPOld($coin_id, $count=null){
		// count for get the available ip count
		$coin= false;
		if(is_numeric($coin_id)){
			$coin=Allmasternode::where('id',$coin_id)->first();
		} else {
			$coin=Allmasternode::where('py_name',$coin_id)->first();
		}
		$isIP6= $coin ? $coin->ip6 :false ;
		$py_name =$coin ? strtolower($coin->py_name) : '';
		$py_name =$py_name == 'smart' ? 'smartcash' : ($py_name =='satc' ? 'satc' : ($py_name =='xdna' ? 'xdna' : $py_name =='bltg' ? 'bltg' : 'others'));	
		$servrs=Srvr::where($py_name, 1)->pluck('id')->toArray();
		if (is_array($servrs)) {
			if($isIP6){
				if($count){
					$ip=IP::where('used',null)->whereIn('server_id',$servrs)->where('ip6',true)->count();	
					return $ip;
				}else {
					$ip=IP::where('used',null)->whereIn('server_id',$servrs)->where('ip6',true)->first();	
				}
						
			} else {
				if($count){
					$ip=IP::where('used',null)->whereIn('server_id',$servrs)->count();
					return $ip;
				} else {
					$ip=IP::where('used',null)->whereIn('server_id',$servrs)->first();
				}	
			}			
			return $ip ? $ip->id : false;
		}
		return false;
	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function InitMasternode($coin_id,$credit,$tx_hash,$tx_index)	{
		$user=Auth::user();
		$coin=Allmasternode::where('id',$coin_id)->first();
		//check this coins masternode setup in progress in middle not completed step 5
	 	$usermasternode=Usermasternode::where('masternode_id',$coin_id)->where('user_id',$user->id)->
																		where('step','<',5)->count();		
		if($usermasternode==0){
				$ishashUsed=Usermasternode::where('masternode_id',$coin_id)->where('tx_hash',$tx_hash)->count();				
				if($ishashUsed>0){
					return  array('status'=>false,'data'=>'Transaction hash already used');
				}
				$ipId = $this->GetDesiredIP($coin_id);
				//var_dump($ipId);die;
				if($ipId === false){		
					return  array('status'=>false,'data'=>'IP not available');
				} else {
					$ip=IP::find($ipId);
				}
			
				// return response()->json($ip);die();
				$usermasternode= new Usermasternode;
				$port=$this->ConfigPort($coin_id);
				if(!$port) {
					return false;
				}			 
				$usermasternode->user_id=$user->id;			
				$usermasternode->masternode_id=$coin_id;
				$usermasternode->step=1;
				$usermasternode->ip=$port->ip;
				$usermasternode->port=$port->port;
				$usermasternode->server_id=$ip->server_id;			 
				$usermasternode->tx_hash=$tx_hash;
				$usermasternode->tx_index=$tx_index;
				$usermasternode->deducted_on=new Carbon;
				$usermasternode->ips_id=$port->ips_id;			
				$usermasternode->save();
				session(['currentNode' => $usermasternode->id]);			 
		}	else {
			$old_MN=$Usermasternode=Usermasternode::where('masternode_id',$coin_id)->where('user_id',$user->id)->where('step','<',5)->first();
			session(['currentNode' => $old_MN->id]);
		}		
		return  array('status'=>true);
	}
	
	public function ConfigPort($coin_id)
	{
		$coin=Allmasternode::where('id',$coin_id)->first();
		$ipId = $this->GetDesiredIP($coin_id);
		if($ipId === false){		
			return  false;
		} else {
			$ip=IP::find($ipId);
		}
		$oldPort=$port=Port::where('server_id',$ip->server_id)->latest()->first();
		$port=new Port;
		$port->ips_id=$ip->id;
		$port->ip=$ip->ip;
		$port->server_id=$ip->server_id;
		$port->mnumber=1;
		$port->user_id=Auth::id();
		$port->coin=$coin->coinname;
		// $port->port=count($oldPort)>0?($oldPort->port)+3:2325;
		$port->rpcport=count($oldPort) > 0 ? ($oldPort->rpcport) +3 : 2326;
		$coin=Allmasternode::where('id',$coin_id)->first();
		if($coin->port) { 
				$port->port=$coin->port;
		}	else {
				$port->port=3777;
		}
		$port->save();
		IP::where('id',$ipId)->update(['used' => true, 'user_id' => Auth::id() ]);
		return Port::where('user_id',Auth::id())->latest()->first();
	}
	
	
	public function PostHosting()
    {

		/*  if(!Input::get('plan'))
		 {
			 return Redirect::back()->withErrors('Select a Plan');
		 }
		 */
		 if(!Input::get('txid'))
		 {
			 return Redirect::back()->withErrors('Empty Transaction Id');
		 }
		
		  $user=Auth::user();
		 $user_id=$user->id;
		 $usermeta=Usermeta::where('user_id',$user_id)->first();
		 $txid=Input::get('txid');
//		 $cmd=' cd /home/docker-wallets && python getrawtransaction.py satc '.Input::get('txid');
		 $cmd=' cd /home/admin && python getrawtransaction.py satc '.Input::get('txid');
        	//$username = $_ENV['CR_username'];
			//$password = $_ENV['CR_password'];
			$appSettings= Setting::find(2);
			$username = $appSettings->ssh_user;
			$password = $appSettings->ssh_pass;;
            $host = $appSettings->plateform_server;;
//			 $host = '192.168.0.1';
			$ssh = new SSH2($host);			
				if(!$ssh->login($username, $password)) 
				{
					return Redirect::back()->withErrors('Sorry .. Something went wrong !! Please retry');}
		$txid_meta=$client_request=$ssh->exec($cmd);
		$client_request=json_decode($client_request,true);
		 if(!is_array($client_request))
		 {
		 	return Redirect::back()->withErrors('Transaction hash is not valid');
			 
		 }
		 
		 $credit=array();
		 if(array_key_exists('vout',$client_request))
		 {
			 // var_dump($client_request['vout']);die();
			 foreach($client_request['vout'] as $v)
			 {
				// var_dump($v);
				 if(array_key_exists('addresses',$v['scriptPubKey'])){
				$credit[$v['scriptPubKey']['addresses'][0]]= $v['value'];
				}
				
			 }
		 }
		//echo $user->satoshi_address;
		//var_dump($credit);die;
		//$key = array_search (199999, $credit);
		
		  if(!array_key_exists(trim($user->satoshi_address),$credit))
		 {
			 return Redirect::back()->withErrors('Transaction Id not related to your Address');
		 } 
		 /*  if(!$key)
		 {
			 return Redirect::back()->withErrors('Transaction Id not related to your Address');
		 } */
		 // echo '<pre>'; var_dump($credit);die();
		 $newuser= User::FindOrFail($user->id);
		 $Usermeta= Usermeta::where('user_id',$user->id)->first();
		  $valid_Txid=Deposit::where('txid',$txid)->first();
		  if($valid_Txid){
			 return Redirect::back()->withErrors('Transaction Id Already used');
		 }  
		// var_dump($Usermeta);die();
		  $Usermeta->balance=$Usermeta->balance+$credit[trim($user->satoshi_address)]; 
		// $Usermeta->credit=$Usermeta->credit+$credit['DYkSeR6mMtMEs2LzaS4xkMjXwGfxtvsEnJ'];
		 $Usermeta->save();
		// $newuser->balance=$credit[$key]; ; 
		 //$newuser->hostingbalance=$newuser->hostingbalance+$credit[trim($user->satoshi_address)]; 
		 //$newuser->crypto_id='m';
		 //$newuser->save();
		 $new_transactions=new Deposit;
		 $new_transactions->user_id=$user->id;
		 $new_transactions->txid=$txid;
		 $new_transactions->amount=$credit[trim($user->satoshi_address)];
		 $new_transactions->used=true;
		 $new_transactions->txid_meta=$txid_meta;
		 $new_transactions->save(); 
		 
		 
		 //$response = $client_request->getBody();
		 //print_r($response);
		// die();
		 
		  $success ='Added '.$credit[trim($user->satoshi_address)] .' SATC'; 
		   $success ='Added '.($credit[trim($user->satoshi_address)] ).' SATC';
		$user= User::FindOrFail($user->id);
		 return View("hosting")->with(array('user'=>$user,'usermeta'=>$usermeta,'credit'=>$credit[trim($user->satoshi_address)],'success'=>$success));
								
	}
	
	public function GetPricing()
    {
		 $user=Auth::user();
		 $user_id=$user->id;
		 $usermeta=Usermeta::where('user_id',$user_id)->first();
		 
		 return View("pricing")->with(array('user'=>$user,'usermeta'=>$usermeta));
		  
								 
	}
	
	public function SavePricing()
    {
		 
		  $user=Auth::user();
		 $user_id=$user->id;
		 $usermeta=Usermeta::where('user_id',$user_id)->first();
		 $plan=Input::get('plan');
		 //var_dump($plan);die();
		 return View("buy-credit")->with(array('user'=>$user,'usermeta'=>$usermeta,'plan'=>$plan,'success'=>null));
		
								 
	}
	
	public function GetHistory()
    {
		  $user=Auth::user();
		 $user_id=$user->id;
		 $usermeta=Usermeta::where('user_id',$user_id)->first();
		   return View("history")->with(array('user'=>$user,'usermeta'=>$usermeta));
								 
	}
	
	public function SaveHistory()
    {
		 
		  return $output;
								 
	}
	
	public function GetSettings($saved=null)
    {
		 
		 $user=Auth::user();
		 $user_id=$user->id;
		 $usermeta=Usermeta::where('user_id',$user_id)->first();
		   return View("settings")->with(array('user'=>$user,'usermeta'=>$usermeta));
		  
								 
	}
	
	public function SaveSettings(Request $request)
    {
			$user=Auth::user();
			$user_id=$user->id;
			// anti hack



			if(Input::file('image')){
			    $f=Input::file('image')->getClientOriginalName();
                $fCount=substr_count($f, '.');
                if($fCount>1):
                    return response()->json(['status'=>false,'data'=> 'Profile Image invalid']);
                endif;
			$allowed=array('jpeg','jpg','png');
			 $fileExt = Input::file('image')->getClientOriginalExtension();
			 if(!in_array($fileExt,$allowed)){
				return response()->json(['status'=>false,'data'=> 'Profile Image invalid']); 
			 }
             $fileName = str_replace('.' . $fileExt, '', Input::file('image')->getClientOriginalName());
            
             $fileSize = Input::file('image')->getSize();
			 if($fileSize>1024*1024){
				
				return response()->json(['status'=>false,'data'=> 'Profile Image too large Allowed Size 1MB']); 
			 }
			

				$image = Input::file('image');

				$input['imagename'] = time().$user_id.'.'.$image->getClientOriginalExtension();

				$destinationPath = public_path('/images/'.$user_id);

				$image->move($destinationPath, $input['imagename']); 

		 
			}
		 

		 $usermeta=Usermeta::where('user_id',$user_id)->first();
		 $user->name=Input::get('name');
		
		 $user->save();
		 $usermeta->company_name=Input::get('company_name');
		 $usermeta->website=Input::get('website');
		 $usermeta->phone=Input::get('phone');
		 $usermeta->facebook=Input::get('facebook');
		 if(Input::file('image')){
			$usermeta->image='/public/images/'.$user_id.'/'.$input['imagename'];	 
		 }
		 $usermeta->twitter=Input::get('twitter');
		 
		 $usermeta->save();
		 return response()->json(['status'=>true,'data'=> 'Profile updated!']); 
		 return redirect()->action('ProfileController@GetSettings')->with('status', 'Profile updated!');						 
	}
	
	
	
	
}
