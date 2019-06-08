<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\HostController;
use Illuminate\Support\Facades\Validator;
use App\Usermeta;
use App\Usermasternode;
use App\Allmasternode;
use App\medic;
use App\port;
use JsonRPC\Client;
use JsonRPC\Server;
use phpseclib\Net\SSH2;
use Auth;
use App\IP;
use App\Srvr ;

use App\Setting;
use phpseclib\Net\SFTP;
use phpseclib\Crypt\RSA;
use Log;
class SatoshiController extends Controller
{
	
   public function __construct($coinid)
    {       
			$this->ssh=null;
			$this->Coin=\App\Allmasternode::find($coinid);	 
			$this->retry=0;	
	}
	public function SSH($ip_id,$retry=null)
	{
		if($retry==null||$retry<10){
			if($ip_id=='genkey'){
				$host = '192.168.0.1';
				$host = '192.168.0.200';
			}	else{
				// edited om March 25th 2019 maybe dont need this , all logic in profile controller
				// /*--------------------need to separate masternode server for smarcashcoin----------------*/
				// if($this->Coin->py_name =='SMART') {
				// 	$smart_serv=Srvr::where('smartcash', 1)->pluck('id')->toArray();
				// 	if (is_array($smart_serv)) {
				// 		$ip=IP::whereIn('server_id',$smart_serv)->first();
				// 		$host=Srvr::find($ip->id);
				// 		$host = $host->localhost;		
				// 	}			
				// }
				// else if($this->Coin->py_name =='SATC') {
				// 		$smart_serv=Srvr::where('satc', 1)->pluck('id')->toArray();
				// 			if (is_array($smart_serv)) {
				// 			$ip=IP::where('used',null)->whereIn('server_id',$smart_serv)->first();
				// 			$host=Srvr::find($ip->server_id);
				// 			$host = $host->localhost;		
				// 		}		
				// } 
				// else {
							$ip=IP::find($ip_id);
							$host=Srvr::find($ip->server_id);
							$host = $host->localhost;
						// }	
		}
        					
			$appSettings= Setting::find(1);
			$username = $appSettings->ssh_user;
			$password = $appSettings->ssh_pass;	
			if($host == '192.168.0.200'){
				$password ='Rn96?3]/^gB(.LF2';
			}
			$ssh = new SSH2($host);			
				if (!$ssh->login($username, $password)) {	
					Log::debug('login retry __LINE__ ='.__LINE__ .' __FUNCTION__ '. __FUNCTION__ );
					sleep(3);
					$this->retry=$this->retry?$this->retry+1:1;
					$this->SSH($ip_id,$this->retry);
					}	else {
					$this->ssh = $ssh;
					return $this->ssh;
				}
			}	else {
			Log::debug('Login Failed max retry reached __LINE__ ');
			die('Login Failed max retry reached');
			}
		
	}
	public function SSH_EXC($cmd,$ip_id)
	{
		if(!$this->ssh){
			Log::debug('executing cmd  '.$cmd);
			$ss=$this->SSH($ip_id,$retry=null);
			
			
			$ck= $this->ssh->exec($cmd);
			//Log::debug('executing cmd  output '.$ck);
			return $ck;
		}
		
				return $this->ssh->exec($cmd);			
			
	}		
	
	public function ServerSetup($usermasternode)
    {   
	   
		
		$ip=IP::find($usermasternode->ips_id);
		$data = '<VirtualHost '.$ip->ip.':80>'
		.PHP_EOL .'ServerAdmin admin@mydomain'.$ip->id.'.com '
		.PHP_EOL .' DocumentRoot /var/www/html/masternode/ip'.$ip->id 
		.PHP_EOL .' ErrorLog ${APACHE_LOG_DIR}/ip'.$ip->id.'_error.log '
		.PHP_EOL .'CustomLog ${APACHE_LOG_DIR}/ip'.$ip->id.'_access.log combined'
		.PHP_EOL .'</VirtualHost>';			
		$dest='/etc/apache2/sites-available/ip'.$ip->id .'.conf';
		
		//$scp = new \phpseclib\Net\SCP($this->SSH($ip->id));
		
		//$ck=$scp->put($dest, $data);
		$written= $this->SCPPUT($usermasternode,$dest,$data);
		 if(!$written){
			 sleep(1);
			 $written=$this->SCPPUT($usermasternode,$dest,$data);
			
		 }
		$path='/var/www/html/masternode/ip'.$ip->id;
		
		$command = 'a2ensite ip'.$ip->id .'.conf &&  service apache2 reload ';
		$output = $this->SSH_EXC($command,$ip->id);
		$command = 'mkdir '.$path .' && chmod -R 777 '.$path;
		$output = $this->SSH_EXC($command,$ip->id);
		
		//return $written;
		return true;
			
	}
	public function SCPPUT($masternode,$path,$data){
		$scp = new \phpseclib\Net\SCP($this->SSH($masternode->ips_id));
		Log::debug('Writing file    '.$path);
		 $written=$scp->put($path, $data);
		 Log::debug('Writing file  output   '.$written?' true ':' false '.$written);
		 return $written;
	}
	
	public function TransactionVerify($cmd){
		return $this->SSH_EXC($cmd,'genkey');
	}
	function MasternodeGenKey($masternode)
    { 	
		//$cmd=' cd /home/docker-wallets && python masternode-genkey.py SATC';
		 //$cmd=' cd /home/docker-wallets && python masternode-genkey.py '.$this->Coin->py_name;
		 $cmd=' cd /home/admin && python masternode-genkey.py '.$this->Coin->py_name;
        
		//$output = $this->SSH_EXC($cmd,$masternode->ips_id);
		  $output = $this->SSH_EXC($cmd,'genkey');
		//var_dump($output);die;		 
		 $outputError='genkey for '.$this->Coin->py_name;
		
		 $cmd_Err=strpos($output,$outputError);
		if (!$cmd_Err){
			
			$a['err']=true;
			$a['data']=$output.__LINE__ ;
			return $a;
		}
		
		$private_key= trim(str_replace($this->Coin->py_name.' :','',substr($output,strpos($output,$this->Coin->py_name)))); 
		if(!$private_key){
			$a['err']=true;
			$a['data']=$output.__LINE__ ;
			return $a;
		}
		if($private_key){
			$a['err']=false;
			$a['private_key']=$private_key;
			$a['data']=$output.__LINE__ ;
			return $a;
		}
		
	}
	function ConfigCoin($masternode){
		
		  // echo $cmd= 'cd /home/docker-wallets && python add-clone-wallet.py --coin='.$this->Coin->py_name.' --mn_id='.$masternode->id.' --alias='.$this->Coin->py_name.$masternode->id.' --ip='.$masternode->ip.' --port='.$masternode->port.' --masternodeprivkey='.$masternode->private_key.' --addr= --start=1 && sleep 5 && python status.py '.$this->Coin->py_name.' '.$masternode->id;
		   $cmd= 'cd /home/docker-wallets && python add-clone-wallet.py --coin='.$this->Coin->py_name.' --mn_id='.$masternode->id.' --alias='.$this->Coin->py_name.$masternode->id.' --ip='.$masternode->ip.' --port='.$masternode->port.' --masternodeprivkey='.$masternode->private_key.' --addr= --start=1 && sleep 5'; 
		 
         $output = $this->SSH_EXC($cmd,$masternode->ips_id);		
		
		 //var_dump($output);die;
		 $outputError='You have to remove (or rename) that container';
		
		 $cmd_Err=strpos($output,$outputError);
		// var_dump($cmd_Err);die;
		 if($cmd_Err){			
			$a['err']=true;
			$a['data']=$output.__LINE__;
			return $a; 
		 }
		 $outputError=$this->Coin->py_name.' '.$masternode->id.' created';		
		 $cmd_Err=strpos($output,$outputError);		
		 if($cmd_Err){			
		 
			$a['err']=false;
			$a['data']=$outputError;
			$a['dataf']=$output.__LINE__;;
		 }	
	
		
		
		}
	
	function Status($m){
		 $cmd= 'cd /home/docker-wallets &&  python status.py '.$this->Coin->py_name.' '.$m->id;		 
         $o=$output = $this->SSH_EXC($cmd,$m->ips_id);
//		 var_dump($output);
		if(strpos($output,'Traceback')){
		$a['err']=true;
		$a['data']=$output;
		$a['dataf']=$o.__LINE__;
		return $a; 	
		}
		 if(strpos($output,'{')){
			 $stripted=substr($output,strpos($output,'{'));			  
			  $output =json_decode($stripted,true);
				if(is_array($output)){
					if($output['status_wallet_synced']===false){
						//sleep(10);
						//$this->Status($m);
					}
					else{
						
						$a['err']=false;
						$a['data']=$output;
						$a['dataf']=$o.__LINE__;
						return $a; 
					}
				}
				 
		 }
		$a['err']=true;
		$a['data']=$output;
		$a['dataf']=$o.__LINE__;
		return $a; 
	}
	function StatusNEW($m){
		 $cmd= 'cd /home/docker-wallets &&  python status.py '.$this->Coin->py_name.' '.$m->id;		 
         $o=$output = $this->SSH_EXC($cmd,$m->ips_id);
		// var_dump($output);
		if(strpos($output,'Traceback')){
		$a['err']=true;
		$a['data']=$output;
		$a['dataf']=$o.__LINE__;
		return $a; 	
		}
		if(strpos($output,'ocket.timeout')){
		$a['err']=true;
		$a['data']="blockchain sync in progress ...";
		$a['dataf']=$o.__LINE__;
		return $a; 	
		}
		 if(strpos($output,'{')){
			 $stripted=substr($output,strpos($output,'{'));			  
			  $output =json_decode($stripted,true);
				if(is_array($output)){
					if($output['status_wallet_synced']===false){
						$a['err']=false;
						$a['data']=$output;
						$a['dataf']=$o.__LINE__;
						return $a; 
					}
					else{
						
						$a['err']=false;
						$a['data']=$output;
						$a['dataf']=$o.__LINE__;
						return $a; 
					}
				}
				 
		 }
		$a['err']=true;
		$a['data']=$output;
		$a['dataf']=$o.__LINE__;
		return $a; 
	}
	
	 function getInfo($masternode)
    {	
		 $command = 'cd /home/docker-wallets && python test-mn-rpc-cloned.py '.$this->Coin->py_name.' '.$masternode->id;
         $output = $this->SSH_EXC($command,$masternode->ips_id);
		 $outputError='Masternode not found in the list of';
		 $cmd_Err=strpos($output,$outputError);
			// var_dump($cmd_Err);die;
		 if($cmd_Err){			
			$a['err']=true;
			$a['data']=substr($output,$cmd_Err);
			$a['dataf']=$output.__LINE__;
			return $a; 
		 }
			$a['err']=false;
			$a['data']=$output;
			$a['dataf']=$output.__LINE__;;
			return $a;
			 			 
	}
	 function getInfoFrontend($masternode,$retry=null)
    {
		 $command = 'cd /home/docker-wallets && python test-mn-rpc-cloned.py '.$this->Coin->py_name.' '.$masternode->id;
         $output = $this->SSH_EXC($command,$masternode->ips_id);
		 $outputError='Masternode not found in the list of';
		 $cmd_Err=strpos($output,$outputError);
			
		 if($cmd_Err){			
			$a['err']=true;
			$a['data']=substr($output,$cmd_Err);
			$a['dataf']=$output.__LINE__;
			return $a; 
		 }
		 $outputError='Traceback';
		 $cmd_Err=strpos($output,$outputError);
			
		 if($cmd_Err){			
			$a['err']=true;
			$a['data']=substr($output,$cmd_Err);
			$a['dataf']=$output.__LINE__;
			return $a; 
		 }
			$a['err']=false;
			$a['data']=$output;
			$a['status']=$output;
			$a['dataf']=$output.__LINE__;;
			return $a;
		 			 
	}
	
	 function WalletInfo($masternode,$retry=null)
    {
		$command = 'cd /home/docker-wallets && python test-rpc-cloned.py '.$this->Coin->py_name.' '.$masternode->id;
         $output = $this->SSH_EXC($command,$masternode->ips_id);
		 $outputError='Masternode not found in the list of';
		 $cmd_Err=strpos($output,$outputError);
			
		 if($cmd_Err){			
			$a['err']=true;
			$a['data']=substr($output,$cmd_Err);
			$a['dataf']=$output.__LINE__;
			return $a; 
		 }
		 $outputError='Traceback';
		 $cmd_Err=strpos($output,$outputError);
			
		 if($cmd_Err){			
			$a['err']=true;
			$a['data']=substr($output,$cmd_Err);
			$a['dataf']=$output.__LINE__;
			return $a; 
		 }
		 //getinfo for SUB1X 4540
		 $str = 'getinfo for '.$this->Coin->py_name.' '.$masternode->id;
		 $output = str_replace($str, '',$output);
		 $output = json_decode($output);
		 
			$a['err']=false;
			$a['data']=$output;
			$a['status']=$output;
			$a['dataf']=$output;
			return $a;
		 			 
	}
	
	 function CoinStop($masternode)
    { 
		$path=$masternode->directory;
		$command=$this->coin.' -conf=mn'.$masternode->id.'.conf -port='.$masternode->port.' -rpcport='.$masternode->rpcport.' -datadir='.$path;
		 $command = 'cd '.$this->pathToCoin.' && '.$command .' stop 2>&1';
         // $output = ($this->SSH())->exec($command);	
		 $output = $this->SSH_EXC($command,$masternode->ips_id);
		$n=Usermasternode::where('id',$masternode->id)->first();
			$n->status='suspended';
			$n->save();	
		return $output;
	}
	 public function CoinStart($masternode)
    { 
		$path=$masternode->directory;
		$command=$this->coind.' -daemon -conf=mn'.$masternode->id.'.conf -port='.$masternode->port.' -rpcport='.$masternode->rpcport.' -datadir='.$path;
		 $command = 'cd '.$this->pathToCoin.' && '.$command .' 2>&1';
         
		// $output =($this->SSH())->exec($command);
		$output = $this->SSH_EXC($command,$masternode->ips_id);
		 $check=strpos($output, "Cannot obtain a lock on data directory");
		
		 if($check){
			$n=Usermasternode::where('id',$masternode->id)->first();
			$n->status='running';
			$n->save();
			 $a['err']=false;
			 $a['data']=$output.__LINE__ .$command;
			
			 return $a;
		 }
		
		elseif (preg_match("/error:/", strtolower($output))){
			
			
			
			$a['err']=true;
			$a['data']=$output.__LINE__ .$command;
			return $a;
		}
		$n=Usermasternode::where('id',$masternode->id)->first();
			$n->status='running';
			$n->save();
		 $a['err']=false;
		$a['data']=$output.__LINE__ .$command;
		return $a;
		
	}
	
	public function StartNode($masternode){
	sleep(2);
	}
	
	public function MyAddress()
	{
			$command = 'cd '.$this->pathToCoin.' && '.$this->coin.' getaccountaddress "account"';
	}
	
	
	public function Delete($masternode)
    {	
		/* first kill the ip process */
		 $cmd ='sudo netstat -plnt | fgrep '.$masternode->ip;
		//sleep(2);
		 $output = $this->SSH_EXC($cmd,$masternode->ips_id);
		 
		 if(!strpos($output,'LISTEN')){
			$output=substr($output,strpos($output,'LISTEN'));
		$output=str_replace('LISTEN','',$output);
		$output=str_replace('/docker-proxy','',$output);
		$output=trim($output);
		$cmd = 'kill -9  '.$output;
		$output = $this->SSH_EXC($cmd,$masternode->ips_id); 
		 }
		
		
		//disable apache vhost new code start
		
		$ip=IP::find($masternode->ips_id);	
		$dest='/etc/apache2/sites-available/ip'.$ip->id .'.conf';
		$command = 'cd /etc/apache2/sites-available && rm -rf ip'.$ip->id .'.conf';
		
         $this->SSH_EXC($command,$masternode->ips_id); 
		$command = 'a2dissite ip'.$ip->id .'.conf &&  service apache2 reload ';
		$output =$this->SSH_EXC($command,$ip->id);
		//var_dump($output);die;
		//disable apache vhost new code end
		
		$Ip=IP::find($masternode->ips_id);
		$Ip->used=null;//IP::find($masternode->ips_id);
		$Ip->user_id=null;//=IP::find($masternode->ips_id);
		$Ip->save();
		 $command='cd /home/docker-wallets && python delete-cloned.py '.$this->Coin->py_name.' '.$masternode->id;
		
	 	$output = $this->SSH_EXC($command,$masternode->ips_id);
		 
		$outputError='Masternode not found in the list of';
		$cmd_Err=strpos($output,'done');
		
		 $alreadystopped=strpos($output,'already stopped');
		
		if($cmd_Err || $alreadystopped){
		
		//Usermasternode::destroy($masternode->id);
		$flight=Usermasternode::find($masternode->id);
		if(count($flight)>0){
		$flight->forceDelete();
		return true;
		}
		}
		return false;
						 
	}
	
}



