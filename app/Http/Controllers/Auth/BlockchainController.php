<?php

namespace App\Http\Controllers\Auth;

use App\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
//use JsonRPC\Client;
use App\usermasternode;
use App\allmasternode;
use JsonRPC\Server;
use phpseclib\Net\SSH2;
use GuzzleHttp\Client;
use Auth;
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);


class BlockchainController extends Controller
{
    
	public function getMnData()
	{
		$int_cltrl='';
		$roi='';
		$coinsAv=Allmasternode::where('active',1)->get()->toArray();
		//var_dump($coinsAv);die;
		
		$satc_mn_data=array();
	     
		/***fetching satc data from satoshi apis server******/
			// foreach($i=0;$i<count($avail_coins);$i++)
			foreach($coinsAv as $key=>$coinA)
			{
				$i=$key;
				$client = new \GuzzleHttp\Client();
				$satc_mn_data[$i] = $client->request('GET', 'http://192.168.0.200:3003/mn_stats_api/'.$coinA['shortnm']); 	
				$mn_data[$i] = json_decode($satc_mn_data[$i]->getBody(),true);
			    $logos=$this->coinsInfo();
				
				$mn_data[$i]['mn_cnt']=$this->getAllRunningMns($coinA['id']);
				
				$mn_data[$i]['logo']=$logos[$i]['logo'];
				$mn_data[$i]['cn_name']=$logos[$i]['name'];
				$mn_data[$i]['explorer_link']=$logos[$i]['explorer_link'];
				$mn_data[$i]['bitcoin_talk']=$logos[$i]['bitcoin_talk'];
				$mn_data[$i]['cn_name']=$logos[$i]['name'];
				$mn_data[$i]['website']=$logos[$i]['website'];
				$mn_data[$i]['github']=$logos[$i]['github'];
				$mn_data[$i]['discord']=$logos[$i]['discord'];
				$mn_data[$i]['twitter']=$logos[$i]['twitter'];
				$mn_data[$i]['coinname']=$logos[$i]['coinname'];
				$mn_data[$i]['kyd']=$logos[$i]['kyd'];
				$mn_data[$i]['active']=$logos[$i]['active'];
				$mn_data[$i]['minbal']=$logos[$i]['minbal'];
				$mn_data[$i]['estmtime']=$logos[$i]['estmtime'];
				
				$mn_data[$i]['id']=$logos[$i]['id'];

			}
			for($i=0;$i<count($mn_data);$i++)
				{
					//var_dump($mn_data[$i]);die;
					//$clt_expl=explode(" ",$mn_data[$i][0]['colaterall']);
					$clt_expl=$mn_data[$i]['minbal'];
					$int_cltrl=$clt_expl[0];
					//$strip_comma = str_replace(",", "", $int_cltrl);
					//$strip_comma = is_numeric($strip_comma)?($strip_comma):$mn_data[$i]['minbal'];
					$strip_comma = $mn_data[$i]['minbal'];
					//var_dump($strip_comma);die;
						if($mn_data[$i][0]['avg_reward_24h']!=0 && is_numeric($strip_comma) && $strip_comma!=0):
						$roi=$strip_comma/$mn_data[$i][0]['avg_reward_24h'];
						if($mn_data[$i][0]['avg_reward_24h']==0 && $strip_comma==0){
							$perc=0;
						}
						else{
							$perc=0;
							//if($)
						$perc=(365 / round($strip_comma/$mn_data[$i][0]['avg_reward_24h']))*100 ;
						}
						$mn_data[$i][0]['roi1']=round($perc);
						$mn_data[$i][0]['roi2']=round($roi);
					    else:
					    $mn_data[$i][0]['roi1']=0;
					    $mn_data[$i][0]['roi2']=0;
					    endif;	
				}
				//echo '<pre>';var_dump($mn_data);die;
           //$mn_data['MNS_TOTAl']=usermasternode::where('step',5)->get()->count();;
           return $mn_data;
	}
	/***
    *function to fetch all running masternodes hosted on platform 
    *
    ***/
    
    public function getAllRunningMns($id)
    {
      
		$masternodes=Allmasternode::where('id',$id)->with('MNS')->first();				
		   //echo '<pre>';
		  // var_dump(count($masternodes->MNS));
		  // var_dump(($masternodes->MNS));
		  
		    return count($masternodes->MNS);

    }
    /***
    *function to fetch all running masternodes coins backside info
    *
    ***/
    public function coinsInfo()
    {
      $coins_info=Allmasternode::where('active',1)->get();	
		    return $coins_info;
    }
	
}

