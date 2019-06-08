<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use Illuminate\Support\Facades\Validator;
use App\Usermeta;
use App\medic;
use App\port;
use JsonRPC\Client;
use JsonRPC\Server;
use phpseclib\Net\SSH2;
use Auth;
class HostingController extends Controller
{
	
   public function __construct()
    {       
		$host = $_ENV['CR_host'];//'69.30.206.170';
		$username = $_ENV['CR_username'];//'root';//
		$password = $_ENV['CR_password'];//'fge9a187p7j1';
		
		$this->coin='MedicCoin';
		$this->coind='./MedicCoind';
		$this->directory_name='medic';
		
			 $ssh = new SSH2($host);
			
				if (!$ssh->login($username, $password)) 
				{
					$this->output ='Login Failed';
				}
				else
				{
					$this->ssh = $ssh;
					
				}
				
		
			
			
	}
    
	public function getNewAddress($id)
    {
		 $command = $this->coind.' getnewaddress masternode'.$id;
         $output = $this->ssh->exec($command);
					
             
				 return $output;				 
	}
	public function StartCoin()
    {
		 $command = 'cd /home/customer  && ./MedicCoind ';
         $output = $this->ssh->exec($command);             
		 return $output;				 
	}
	
	public function MyAddress()
	{
			$startCoin=$this->StartCoin();
			//var_dump($startCoin);
			 $MyAddress = 'cd /home/customer  && ./MedicCoind getaccountaddress "account"';
			 $MyAddress_output = $this->ssh->exec($MyAddress);			
				 if (preg_match("/error:/", strtolower($MyAddress_output))){ 
				 return array('status'=>false,'error'=>$MyAddress_output,'line'=>__FILE__ .'/'.__LINE__);
						}
				 else{
					 $user=Auth::user();
					 $user=User::where('id',$user->id)->first();
					 $user->crypto_id=$MyAddress_output;
					 $user->save();
					 return array('status'=>true,'address'=>$MyAddress_output,'line'=>__FILE__ .'/'.__LINE__);
				 }
		
	}
	
	public function TransferHostingCharges($user,$amount)
	{ 
		
		$clientaddress=$this->MyAddress();
		//var_dump($clientaddress);die();
		$clientaddress=$clientaddress['address'];//'MMTknE3qFDQZ2rkqcCuyyJ6KWvPdpq7VZr';
		
		$port=Port::where('user_id',$user->id)->where('coin',$this->coin)->orderby('created_at', 'desc')->first();
		if(count($port)>0){
			
			$path='/var/www/html/';
			$path=$path.'www.satoshi'.$user->id.'.com';
			$command=$this->coin.' -daemon -conf=mn'.$user->id.'.conf -port='.$port->port.' -rpcport='.$port->rpcport.' -datadir=/var/www/html/www.satoshi'.$user->id.'.com ';
			if($user->hostingbalance>5){
			 $check_balance = 'cd '.$path.' && '.$command.' getbalance';
			 $check_balance_output = $this->ssh->exec($check_balance);
			
				 if (preg_match("/error:/", strtolower($check_balance_output))){ 
					//try to restart coin server
					$CoinStart=$this->CoinStart($user,$port);
					if($CoinStart['status']==true){$this->TransferHostingCharges($user,$amount);}
					else{ return $CoinStart;}
					// return array('status'=>false,'error'=>$check_balance_output);
				 }
				 
				else{
					
						 return array('status'=>true,'error'=>'ok cut the balance','line'=>__FILE__ .'/'.__LINE__);
					
				}
			}
			else{
				// stop coin due to insuffiecient bal
				
				 $stop = 'cd '.$path.' && '.$command.' stop';
				 $send_balance_output = $this->ssh->exec($stop);
				 return array('status'=>false,'error'=>'Masternode not launched','line'=>__FILE__ .'/'.__LINE__);
			}
			}
		 return array('status'=>false,'error'=>'Masternode not launched','line'=>__FILE__ .'/'.__LINE__);
	
	}
	
	
}
