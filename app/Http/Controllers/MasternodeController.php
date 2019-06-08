<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Response;
use App\Http\Controllers;
use App\Http\Controllers\MedicController;
use App\Http\Controllers\SatoshiController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Usermeta;
use App\medic;
use App\port;
 use App\IP;
 use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Faker\Factory as Faker;
use App\usermasternode;
use App\allmasternode;
class MasternodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');		
		$coinid=Input::get('coinid');
		$this->CoinM=$CoinM=Allmasternode::find($coinid);
		
		//$controller = $app->make('\App\Http\Controllers\\'. $CoinM->controller );
		$controller =new  SatoshiController($coinid);
		$this->CoinController=$controller;
		$this->coin=$CoinM->coinnamed;
		$this->coinname=$CoinM->coinname;
    }
	public function NodeSetup(){
		$coinid=Input::get('coinid');
		 $step=$this->GetProcess($coinid);
		//sleep(2);		
		 //var_dump($step);die();
		 
		if($step==1){$this->StepOne($coinid);}		
		elseif($step==2){$this->GeneratePrivateKey($coinid);}
		elseif($step==3){$this->ConfigureCoin($coinid);}
		elseif($step==4){$this->CheckStatusMNS($coinid);}		
		elseif($step==4.5){$this->StartNodeInstruction($coinid);}		
		elseif($step==5){$this->StartNode($coinid);}
		
	}
	public function SaveProcess($step,$coinid)
	{
		if(Auth::check())
		{
			$usermasternode=Usermasternode::where('masternode_id',$coinid)->where('user_id',Auth::id())->latest()->first();
			// $user=User::where('id',Auth::id())->first();
			$usermasternode->step=$step;
			$usermasternode->save();
			return response::json([$usermasternode,$coinid]);
		}
	}
	public function GetProcess($coinid)
	{
		if(Auth::check())
		{
			
			$usermasternode=Usermasternode::where('masternode_id',$coinid)->where('user_id',Auth::id())->latest()->first();
		//return response::json($usermasternode);
			
			return $usermasternode->step;
			
		}
		else false;
	}
	public function MasterkeySave($coinid,$key)
	{
		if(Auth::check())
		{
			
			$usermasternode=Usermasternode::where('masternode_id',$coinid)->where('user_id',Auth::id())->latest()->first();
			$usermasternode->private_key=$key;
			$usermasternode->save();
			//return $usermasternode->step;
			
		}
		else false;
	}
	public function StepOne($coinid)
	{
		$usermasternode=Usermasternode::where('masternode_id',$coinid)->where('user_id',Auth::id())->latest()->first();
		$ip=IP::find($usermasternode->ips_id);
		$Medic=  $this->CoinController;
		// $host=new HostController;
		// $ck =$host->VirtualHost($ip);
		// if(!$ck==true){exit('VirtualHost setup Failed');}
		$usermasternode=Usermasternode::where('masternode_id',$coinid)
				->where('user_id',Auth::id())->latest()->first();
		$server=$Medic->ServerSetup($usermasternode);	
			
		if(!$server==true)
		{			
			$e['status']=true;
			$e['data']='Processing ...<br/> press next to continue';
			$e['debug']=$server;
			$e['auto']=true;
			echo json_encode($e);exit;
		}
		 $e['status']=true;
		 $e['data']='1. Server Setup completed <br/> 2. '.$this->coinname.' Installed <br/> 3. configuring ' .$this->coinname.' ...';
			$e['step']=2;
			$e['auto']=true;
			$e['swal']='configuring masternode ...';
			$this->SaveProcess(2,$coinid);
			echo json_encode($e);exit;
	}
	public function ConfigureCoin($coinid)
	{
		$Medic=  $this->CoinController;
		$usermasternode=Usermasternode::where('masternode_id',$coinid)
				->where('user_id',Auth::id())->latest()->first();
		$ConfigCoin=$Medic->ConfigCoin($usermasternode);
		if($ConfigCoin['err']==false){
			$this->SaveProcess(4,$coinid);
			$e['status']=true;
			$e['step']=4;
			$e['auto']=true;
			// define wait time for user (coin installtion time ie. 10 mint for PIVX)			
			$e['timeout']=$this->CoinM->timeoutgap;
			$e['swal']='Wallet restarting ..';
			$e['data']='1. Server Setup completed <br/> 2. '.$this->coinname.' Installed <br/> 3. configuring '.$this->coinname.' ...Configuring Coin finished<br>Generated private key is '.$usermasternode->private_key.'<br> Attaching private key to ip ("'.$usermasternode->ip.'")';
			echo json_encode($e);exit;
			$this->SaveProcess(3,$coinid);
			$e['status']=true;
			$e['auto']=true;
			$e['step']=3;$e['swal']='generating '.$this->CoinM->masternode.' private key ..';
			$e['data']='1. Server Setup completed <br/> 2. '.$this->coinname.' Installed <br/> 3. configuring '.$this->coinname.' ...Configuring Coin finished';
			echo json_encode($e);exit;
		}		
			$e['status']=true;
			$e['auto']=true;
			$e['data']='Processing ...<br/> press next to continue';
			$e['debug']=$ConfigCoin;			
			echo json_encode($e);exit;
	}
	public function GeneratePrivateKey($coinid)
	{		
		$CoinController=  $this->CoinController;
		$usermasternode=Usermasternode::where('masternode_id',$coinid)->where('user_id',Auth::id())->latest()->first();	
		 $masterkey=$CoinController->MasternodeGenKey($usermasternode);
		 
		 if($masterkey['err']==true)
		{
			$e['status']=true;
			$e['auto']=false;
			$e['data']='Processing ...<br/> press next to continue';
			$e['debug']=$masterkey;
			echo json_encode($e);exit;
		}
		elseif ($masterkey['err']==false){
			$this->MasterkeySave($coinid,$masterkey['private_key']);
			$this->SaveProcess(3,$coinid);
			
			$e['status']=true;
			$e['step']=3;$e['swal']='generating '.$this->CoinM->masternode.' private key ..';
			$e['auto']=true;
			$e['data']='1. Server Setup completed <br/> 2. '.$this->coinname.' Installed <br/> 3. configuring '.$this->coinname.' ...Configuring Coin finished';
			echo json_encode($e);exit;
		}
			$e['status']=true;
			$e['auto']=true;
			$e['data']='Processing ...<br/> press next to continue';
			$e['debug']=$masterkey;
			echo json_encode($e);exit;		
	}
	function CheckStatusMNS($coinid){		
	  	$user= Auth::user();
		 $usermasternode=Usermasternode::where('masternode_id',$coinid)->where('user_id',Auth::id())->latest()->first();
		 $CoinController=  $this->CoinController;
		 $Status=$CoinController->StatusNEW($usermasternode);
		
		 //$block=$CoinController->WalletInfo($usermasternode);
		 //var_dump($block);
		// die;
		 
			if($Status['err'])
				{ 
					/*-------------need to print blocks--------------*/
				  
					if($Status['data'] =='blockchain sync in progress ...'){
					$this->SaveProcess(4,$coinid);			
					$e['status']=true;
					$e['step']=4;
					$e['sync']=1;
					$e['auto']=false;
					$e['timeout']=$this->CoinM->timeoutgap;
					$e['redirect']=url("/home/view/".$usermasternode->id);
					$e['data']=$Status['data'];
					$e['debug']=$Status['dataf'];
					echo json_encode($e);exit;	
					}
					// masterkey not found so rollback to step 3rd
					$this->SaveProcess(4,$coinid);			
					$e['status']=true;
					$e['step']=4;
					$e['auto']=true;
					$e['timeout']=$this->CoinM->timeoutgap;
					$e['redirect']=url("/home/view/".$usermasternode->id);
					$e['data']=$Status['data'];
					$e['debug']=$Status['dataf'];
					echo json_encode($e);exit;
					
				}
				//$usermasternode->status=$Status['data']['status_mn_online']?'Running':'Suspended';
				 
		//var_dump($Status);		
		if($Status['data']['status_wallet_synced']== false){
			
			$block=$CoinController->WalletInfo($usermasternode);
				$e['status']=true;
				$e['step']=4;
				$e['sync']=0;
				$e['Statusoutput']=$Status;
				if($usermasternode->masternode_id ==3 ){
					$e['block']='Blockchain sync in progess';
					
				}
				else {
				$e['block']=' Blockchain sync in progress :<strong>'.@$block['data']->blocks.'</strong> Synced Blocks';
				} 
				$e['auto']=false;
				$e['timeout']=$this->CoinM->timeoutgap;
				$e['data']=$block['data'];
				$e['debug']='';
				echo json_encode($e);exit;
		}		
		$usermasternode->status='running';
		$usermasternode->save();
		$this->SaveProcess(4.5,$coinid);	
		$e['status']=true;
		$e['debug']=$Status['dataf'];
		$e['step']=4.5;
		$e['auto']=true;
		$e['d']=$Status['data'];
		$e['__LINE__']=__LINE__;		
		$e['swal']='Masternode starting ..';
		if (!filter_var($usermasternode->ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
			$hasBracket = strpos($usermasternode->ip, '[');
			if($hasBracket<1)	{
				$usermasternode->ip = '['.$usermasternode->ip.']';
			}
		} 
			$e['data']='1. Server Setup completed <br/> 2. '.$this->coinname.' Installed <br/> 3. configuring '.$this->coinname.' ...Configuring Coin finished<br>Generated '.$this->CoinM->masternode.' private key is '.$usermasternode->private_key.'<br> Connecting SatoshiSolutions platform to ("'.$usermasternode->ip.':'.$usermasternode->port.'")';
			echo json_encode($e);exit;
	}	
	public function StartNodeInstruction($coinid){
		
		$usermasternode=Usermasternode::where('masternode_id',$coinid)->where('user_id',Auth::id())->latest()->first();
		session()->forget('currentNode');
		// $CoinController= $this->CoinController;
		// $StartNode=$CoinController->StartNode($usermasternode);
			$this->SaveProcess(5,$coinid);
			$e['status']=true;
			$e['step']=5;
			$e['auto']=false;
			$e['redirect']=url("/home/view/".$usermasternode->id);
				if (!filter_var($usermasternode->ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
					$hasBracket = strpos($usermasternode->ip, '[');
					if($hasBracket<1)	{
						$usermasternode->ip = '['.$usermasternode->ip.']';
					}
				} 
			$e['data']=' masternode has been started on server,still to run it successfully add all info in wallet and after that click next.   <br/>
			1. Copy the line below and add to the masternode.conf in your local wallet </br></br>
			<div style="text-align:left;"id="copy-target">'.$this->coinname.($usermasternode->id).' '.$usermasternode->ip.':'.$usermasternode->port.' '.$usermasternode->private_key.' '.$usermasternode->tx_hash .' '.$usermasternode->tx_index .'</div>
			<button class="copy-button fa fa-copy" data-clipboard-action="copy" data-clipboard-target="#copy-target">Copy</button></br></br>
			2. Save the config file <br/>3. Restart local wallet <br/>
			4.start masternode from your local wallet and press next ';;
			$e['swal']='Masternode status checking ..';
			//$e['debug']=$StartNode;
			echo json_encode($e);exit;
		
	}
	public function StartNode($coinid){
		session()->forget('currentNode');
		$usermasternode=Usermasternode::where('masternode_id',$coinid)
				->where('user_id',Auth::id())->latest()->first();
		$CoinController= $this->CoinController;
		//$StartNode=$CoinController->StartNode($usermasternode);
		//var_dump($StartNode);die;
		//if($StartNode['err']==true && strpos($StartNode['data'],'suitable')){
			$this->SaveProcess(5,$coinid);
			$e['status']=true;
			$e['step']=5;
			$e['auto']=false;
			$e['swal']='Checking  masternode status';
			
			$e['data']=' If your masternode successfully starts, congratulations!, sit back and enjoy your passive income<br/> If your masternode does not successfully start, visit us on Discord where we would be more than happy to assist you</br>';
			//$e['debug']=$StartNode['data'];
			$e['redirect']=url("/home/view/".$usermasternode->id);
			
			echo json_encode($e);exit;
		
	}
	
	
	
	public function CheckStatus()
	{	
		$masternode_id=Input::get('masternode_id');
		if(!$masternode_id){
			$usermasternode=Usermasternode::where('masternode_id',$coinid)
				->where('user_id',Auth::id())->latest()->first();
		}
		else{
			$usermasternode=Usermasternode::where('id',$masternode_id)
				->where('user_id',Auth::id())->first();
		}
		
 
		$CoinController=  $this->CoinController;
		$getInfoFrontend=$CoinController->getInfoFrontend($usermasternode);
		echo json_encode($getInfoFrontend);exit;
		return response()->json($getInfoFrontend);
	}
	
	public function WalletInfo()
	{	
		$masternode_id=Input::get('masternode_id');
		if(!$masternode_id){
			$usermasternode=Usermasternode::where('masternode_id',$coinid)
				->where('user_id',Auth::id())->latest()->first();
		}
		else{
			$usermasternode=Usermasternode::where('id',$masternode_id)
				->where('user_id',Auth::id())->first();
		}
		
 
		$CoinController=  $this->CoinController;
		$WalletInfo=$CoinController->WalletInfo($usermasternode);
		echo json_encode($WalletInfo);exit;
		return response()->json($WalletInfo);
	}
	public function Delete($id)
	{
		$masternode_id=Input::get('masternode_id');
		 $usermasternode=Usermasternode::where('id',$id)
				->where('user_id',Auth::id())->first();
		if(count($usermasternode)==0){
			
			echo json_encode(['status'=>false,'data'=>'Masternode not exist']);exit;
		}
		$CoinController=  $this->CoinController;
		$Delete=$CoinController->Delete($usermasternode);
		if(!$Delete){
			Usermasternode::destroy($id);
		}
		echo json_encode(['status'=>true,'data'=>'Masternode has been deleted ','redirect'=>url('/moniter')]);exit;
		
		
	}
}
