<?php
namespace App\Http\Controllers\Admin;
use App\User;
use Auth;
use Response;
//use App\Http\Controllers;
use App\Http\Controllers\MedicController;
use App\Http\Controllers\SatoshiController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Usermeta;
use App\medic;
use App\port;
use Log;
use App\IP;
use App\Srvr ;
use JsonRPC\Client;
use JsonRPC\Server;
use phpseclib\Net\SSH2;
use phpseclib\Net\SFTP;
use phpseclib\Crypt\RSA;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Faker\Factory as Faker;
use App\usermasternode;
use App\allmasternode;
use App\Setting;
class MasternodeController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
		$this->ssh=null;
			 
			$this->retry=0;	
    }
	public function SSH($ip_id,$retry=null)
	{
		
		
		if($retry==null||$retry<10){
		
		
		if($ip_id=='genkey'){
			 $host = '192.168.0.1';
		}
		else{
			$ip=IP::find($ip_id);
			$host=Srvr::find($ip->server_id);
			$host = $host->localhost;
		}		
			$appSettings= Setting::find(2);
			$username = $appSettings->ssh_user;
			$password = $appSettings->ssh_pass;		
			 $ssh = new SSH2($host);			
				if (!$ssh->login($username, $password)) 
				{	
					Log::debug('login retry __LINE__ ='.__LINE__ .' __FUNCTION__ '. __FUNCTION__ );
					sleep(3);
					$this->retry=$this->retry?$this->retry+1:1;
					$this->SSH($ip_id,$this->retry);
					}
				else
				{
					$this->ssh = $ssh;
					return $this->ssh;
				}
		}
		else{
			Log::debug('Login Failed max retry reached __LINE__ ');
			die('Login Failed max retry reached');	}
		
	}
	public function SSH_EXC($cmd,$ip_id)
	{
		if(!$this->ssh){
			Log::debug('executing cmd  '.$cmd);
			$ss=$this->SSH($ip_id,$retry=null);
			
			$ck= $this->ssh->exec($cmd);
			Log::debug('executing cmd  output '.$ck);
			return $ck;
		}
		
				return $this->ssh->exec($cmd);			
			
	}		
	
	
	 function CheckStatus()
    {
		$CoinM=Allmasternode::find(Input::get('coinid'));
		$masternode=usermasternode::find(Input::get('masternode_id'));
		
		$masternode_id=Input::get('masternode_id');
		 $command = 'cd /home/docker-wallets && python test-mn-rpc-cloned.py '.$CoinM->py_name.' '.$masternode->id;
         $output = $this->SSH_EXC($command,$masternode->ips_id);
		 $outputError='Masternode not found in the list of';
		 $cmd_Err=strpos($output,$outputError);
			
		 if($cmd_Err){			
			$a['err']=true;
			$a['data']=substr($output,$cmd_Err);
			
			return response()->json($a);
			//return $a; 
		 }
		 $outputError='Traceback';
		 $cmd_Err=strpos($output,$outputError);
			
		 if($cmd_Err){			
			$a['err']=true;
			$a['data']=substr($output,$cmd_Err);
			
			return response()->json($a);
		 }
			$a['err']=false;
			$a['data']=$output;
			$a['status']=$output;
			
			return response()->json($a);
		 			 
	}
	
	public function Delete($id)
    {	
		$this->Coin=Allmasternode::find(Input::get('coinid'));		
		$masternode_id=Input::get('masternode_id');
		 $masternode=Usermasternode::find($id);
				
		if(count($masternode)==0){
			
			echo json_encode(['status'=>false,'data'=>'Masternode not exist']);exit;
		}
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
		
		if($cmd_Err){
		
		//Usermasternode::destroy($masternode->id);
		$flight=Usermasternode::find($masternode->id);
		$flight->forceDelete();
		return response()->json(['status'=>true,'data'=>'Masternode has been deleted ','redirect'=>url('/admin/user/'.$masternode->user_id)]);
		}
		return response()->json(['status'=>true,'data'=>'Masternode has been deleted ','redirect'=>url('/admin/user/'.$masternode->user_id)]);
						 
	}
	public function Deleteold($id)
	{
		$CoinM=Allmasternode::find(Input::get('coinid'));
		 $app = app();
		$controller = $app->make('\App\Http\Controllers\\'. $CoinM->controller );
		$this->CoinController=$controller;//$CoinM->controller;
		$masternode_id=Input::get('masternode_id');
		 $usermasternode=Usermasternode::findorfail($id);
				
		if(count($usermasternode)==0){
			
			echo json_encode(['status'=>false,'data'=>'Masternode not exist']);exit;
		}
		$CoinController=  $this->CoinController;
		$Delete=$CoinController->Delete($usermasternode);
		if(!$Delete){
			Usermasternode::destroy($id);
		echo json_encode(['status'=>true,'data'=>'Masternode has been deleted ','redirect'=>url('/moniter')]);exit;
		}
		
	}
}
