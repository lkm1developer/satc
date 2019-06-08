<?php

namespace App\Http\Controllers;
use Redirect;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\BlockchainController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Usermeta;
use Auth;
use JsonRPC\Client;
use JsonRPC\Server;
use phpseclib\Net\SSH2;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\IP;
use App\Srvr ;
use phpseclib\Net\SFTP;
use phpseclib\Crypt\RSA;
use Carbon\Carbon;
use Log;
use App\Setting;
use Illuminate\Support\Facades\Cache;
class HostController extends Controller

{
	 public function __construct()
    { 
		$this->retry=null;
	}
	
	public function SSH($ip_id,$retry=null)
	{	
		if($retry==null||$retry<4){
		$ip=IP::find($ip_id);
		$host=Srvr::find($ip->server_id);		
		$host = $host->localhost;
		$appSettings= Setting::find(1);
			$username = $appSettings->ssh_user;
			$password = $appSettings->ssh_pass;;	
			 $ssh = new SSH2($host);
			//$ssh->setTimeout(300);
				if (!$ssh->login($username, $password)) 
				{	sleep(3);
					//retry again 
					$this->retry=$this->retry?$this->retry+1:1;
					$this->SSH($ip_id,$this->retry);
					die('Login Failed retry');	}
				else
				{
					$this->ssh = $ssh;
					return $this->ssh;
				}
		}
		else{die('Login Failed max retry reached');	}
	}
	public function SSH_EXC($cmd,$ip_id)
	{
		
		sleep(2);
		if(!$this->ssh){
			$ss=$this->SSH($ip_id,$retry=null);
			return $ss->exec($cmd);
		}
				return $this->ssh->exec($cmd);
				
				
			
	}		
	
	 public function check($location,$ip)
	{
		
		$cmd= '[ -d "'.$location.'" ] && echo "true"';
		$output = ($this->SSH($ip->id))->exec($cmd);
		return $output;		
	}
	
	
    public function  VirtualHost($ip)
	{
		$data = '<VirtualHost '.$ip->ip.':80>'
		.PHP_EOL .'ServerAdmin admin@mydomain'.$ip->id.'.com '
		.PHP_EOL .' DocumentRoot /var/www/html/masternode/ip'.$ip->id 
		.PHP_EOL .' ErrorLog ${APACHE_LOG_DIR}/ip'.$ip->id.'_error.log '
		.PHP_EOL .'CustomLog ${APACHE_LOG_DIR}/ip'.$ip->id.'_access.log combined'
		.PHP_EOL .'</VirtualHost>';		
		
		$dest='/etc/apache2/sites-available/ip'.$ip->id .'.conf';
		
		$scp = new \phpseclib\Net\SCP($this->SSH($ip->id));
		
		$ck=$scp->put($dest, $data);
		
		$path='/var/www/html/masternode/ip'.$ip->id;
		
		$command = 'a2ensite ip'.$ip->id .'.conf &&  service apache2 reload && mkdir '.$path .' && chmod -R 777 '.$path;
		$output = $this->SSH_EXC($command,$ip->id);
		
				
		

		
	return true;
	}
	public function getNewAddress()
    {
		
			$email=(Auth::user())->email;
			$wallet_cmd ='  cd /home/admin && python create-account.py SATC '.md5($email);
			$appSettings= Setting::find(2);
			$username = $appSettings->ssh_user;
			$password = $appSettings->ssh_pass;;	
			$ssh = new SSH2($appSettings->plateform_server);		
			if (!$ssh->login($username, $password)) {
				return false;
			} else {
				$this_ssh = $ssh;
			}
			$output = $this_ssh->exec($wallet_cmd);				
		    return $output;				 
	}
	public function GetBalance(){
		$cmd=' cd /home/admin && python balance.py SATC';
		$appSettings= Setting::find(2);
		$username = $appSettings->ssh_user;
		$password = $appSettings->ssh_pass;
		$ssh = new SSH2($appSettings->plateform_server);			
		if (!$ssh->login($username, $password)){
			return false;
		}
		$bal=$ssh->exec($cmd);
		return $bal;
	}

	
	public function TransferHostingCharges($amount)
	{ 
		$setting=Setting::find(2);
		$clientaddress=$setting->admin_address??'sLZtHp8kkLEMLTeespf9Hrd7pHiHfA5QJP';
		$bal=$this->GetBalance(true);		
		echo $d='  bal '.$bal.' to deduct '.$amount.' ';
		Log::info( ' hosting charges sendtoadmin bal check  '.$d);
		if(!$bal){
			$bal= Cache::get('CheckBalance');
		}
		if($bal && $amount){
			if($bal>$amount){
				if((float)$bal>(float)$amount){
					echo ' prepare to transfer ';
					$appSettings= Setting::find(2);
					$username = $appSettings->ssh_user;
					$password = $appSettings->ssh_pass;;	
					$ssh = new SSH2($appSettings->plateform_server);
					$ssh->setTimeout(300);	
					if (!$ssh->login($username, $password)){
						echo 'login Failed';exit('login Failed');
					} else {
						$this_ssh = $ssh;
					}					
					
					$cmd=' cd /home/admin && python withdraw.py SATC '.$clientaddress.' '.$amount;
			
					$output = $this_ssh->exec($cmd);
					if($output){
						if(strpos($output,'rror')){
							Log::info( ' failedforsendtoadmin   '.$cmd. ' output '.$output);
						} else {
							Log::info(' Successforsendtoadmin  '.$cmd. ' output '.$output);
						}
						echo  $output;
					}
					
				}
			}
		}
	}
	public function Withdraw($address,$amount)
    {
		$bal=$this->GetBalance(true);
		if($bal<$amount){
			return array('staus'=>0,'data'=>'Insuffiencient balance');
		}
			$appSettings= Setting::find(2);
			$username = $appSettings->ssh_user;
			$password = $appSettings->ssh_pass;;	
			$ssh = new SSH2($appSettings->plateform_server);
			$ssh->setTimeout(300);
			if (!$ssh->login($username, $password)) {
				exit('login Failed');
			} else {
				$this_ssh = $ssh;	
			}
			$cmd=' cd /home/admin && python withdraw.py SATC '.$address.' '.$amount;			
			$output = $this_ssh->exec($cmd);
			if($output){
				if(strpos($output,'rror')){
					Log::info( ' failedwithdrawbalance   '.$cmd. ' output '.$output);
					$json_decode= json_decode(str_replace('error:','',$output));				
					return array('staus'=>false,'data'=>$json_decode->message,'debug'=>$output);
				} else {
					Log::info(' successwithdrawbalance  '.$cmd. ' output '.$output);
					 return array('staus'=>true,'data'=>'Request completed Transaction hash is '.$output);
				}
				
			}
			return array('staus'=>false,'data'=>'Something went wrong ','debug'=>$output);
	}

	
}
