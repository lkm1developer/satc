<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\usermasternode;
use App\allmasternode;
use JsonRPC\Server;
use phpseclib\Net\SSH2;
use GuzzleHttp\Client;
use Auth;
use DB;
use Session;
use Cache;
class CoinPageController extends Controller
{
   
   public function coinpage(){
	//    $coins=$this->data();
	   $coins=$this->CryptoStats();
	   $firstFive=array_slice($coins,0,6);
		$Rest=array_slice($coins,6);
		usort($Rest, function($a, $b) {
			return $a['getAllRunningMns'] <=> $b['getAllRunningMns'];
		});
		 
		//return response()->json($coins);
        return view('coin-page')->with('firstFives',$firstFive)->with('Rests',array_reverse($Rest));		
   }
   public function Stats(){
	   $coins=$this->data();
	   $today = Carbon::today();
	   $mnsHosted= usermasternode::where('step',5)->get()->count();
	   $firstMNS= usermasternode::where('step',5)->orderBy('created_at','asc')->first();
	   $rt=$ref=$from = Carbon::createFromFormat('Y-m-d H:s:i',$firstMNS->created_at );
	   $to = Carbon::createFromFormat('Y-m-d H:s:i', $today);
		$start=$from->startOfMonth()->format('Y-m-d H:s:i');
		$end =$ref->endOfMonth()->format('Y-m-d H:s:i');
	   $monthChartData= array();
	   $monthChartDay= array();
	   while(strtotime($start)<time()) {
			$s=usermasternode::
				where('step',5)->whereBetween('created_at',[$start, $end])->get()->count();
			array_push($monthChartData,$s);
			$newStamp= Carbon::createFromFormat('Y-m-d H:s:i',$end );
			array_push($monthChartDay,'"'.$newStamp->format('M Y').'"');
			$startStamp=$newStamp->addDays(1);
			$start=$startStamp->format('Y-m-d H:s:i');
			$end=$newStamp->endOfMonth()->format('Y-m-d H:s:i');
		}
	   $mnsHostedToday= usermasternode::
						where('step',5)
						->whereDate('created_at','>=', $today)
						->get()->count();
	   $coinsListed= allmasternode::get()->count();
	   $usersListed= User::get()->count();
		$worth =0;
		foreach($coins as $key=>$coin){
			$percentLeft=round((((int)$coin['getAllRunningMns']/$mnsHosted)*100),2);
			$coins[$key]['percentLeft']= $percentLeft;
			$percentRight=0;
			if((int)$coin['apidata']['nb_node']){
			$percentRight= round((((int)$coin['getAllRunningMns']/(int)$coin['apidata']['nb_node'])*100),2);
			}
			$coins[$key]['percentRight']= $percentRight;
			$c =(int)$coin['getAllRunningMns']*(float)$coin['apidata']['mn_worth_usd'];
			$worth = $worth+$c;
		}
		$lefts=$rights =$coins;
		usort($lefts, function($a, $b) {
			return $a['percentLeft'] <=> $b['percentLeft'];
		});
		usort($rights, function($a, $b) {
			return $a['percentRight'] <=> $b['percentRight'];
		});
		/*----------getting top 10 users--------*/
		$top_users=$this->topUsers();
		$data =array(
		'lefts'=>array_reverse($lefts),
		'rights'=>array_reverse($rights),
		'mnsHosted'=>$mnsHosted,
		'mnsHostedToday'=>$mnsHostedToday,
		'coinsListed'=>$coinsListed,
		'usersListed'=>$usersListed,
		'worth'=>$worth,
		'monthChartData'=>$monthChartData,
		'monthChartDay'=>$monthChartDay,
		'top_users'=>$top_users,
		);
		//return response()->json($data);
        return view('stats')
		->with($data)
		;		
   }
   public function login(){
	   $coins=$this->data();
	   $firstFive=array_slice($coins,0,6);
		$Rest=array_slice($coins,6);
		usort($Rest, function($a, $b) {
			return $a['getAllRunningMns'] <=> $b['getAllRunningMns'];
		});
	 
		return array_merge($firstFive,array_reverse($Rest));
		//return response()->json($satc_mns_data);
        //return view('coin-page')->with('firstFives',$firstFive)->with('Rests',array_reverse($Rest));		
   }
   public function CryptoStats()
    {
		if(Cache::has('CryptoStats')){
			return Cache::get('CryptoStats');
		} else {
			$coins=Allmasternode::where('active',1)->get()->toArray();
			$url='https://masternodes.online/mno_api/?apiseed=MNOAPI-0063-ac44ae38-5c9bea7e-285b-2193405f';
			$client = new \GuzzleHttp\Client();
			$apidata = $client->request('GET', $url);
			$mn_data = json_decode($apidata->getBody(), true);
			if (is_array($mn_data)){
				if (sizeof($mn_data) > 0){
					unset($mn_data[0]);
				}
			}
			foreach($coins as $key=>&$coin) {
				$coin['getAllRunningMns']=$this->getAllRunningMns($coin['id']);				
				$coin['mn_data']='';				
				if($coin){
					if ($mn_data){
						if (is_array($mn_data)){
							if (sizeof($mn_data) > 0){							
								$found = array();
								foreach($mn_data as $arr){								
									if($arr['coin_ticker']==strtoupper($coin['shortnm'])){
										$found = $arr;
									}								
								}
								$coin['mn_data'] = $found;
							}
						}
					}
				}
			} 
			Cache::put('CryptoStats' , $coins,  now()->addMinutes(5));
			return Cache::get('CryptoStats');
		}
    }

	public function data()
	{
		$coins=Allmasternode::where('active',1)->get()->toArray();
		foreach($coins as $key=>$coin)
		{
			
			$client = new \GuzzleHttp\Client();
			$apidata= $client->request('GET', 'http://192.168.0.200:3003/mn_stats_api/'.$coin['shortnm']); 
			$apidata= json_decode($apidata->getBody(),true)[0];	
			unset($apidata['detail_reward_24h']);
			//var_dump($apidata);die;
			$coins[$key]['getAllRunningMns']=$this->getAllRunningMns($coin['id']);
				
					$min_bal = $coin['minbal'];
					$roi1=0;
					$roi2=0;
					$avg_reward=$apidata['avg_reward_24h'];
					if($avg_reward !=0 && is_numeric($min_bal) && $min_bal!=0){
						$roi=$min_bal/$avg_reward;
						if($avg_reward==0 && $min_bal==0){
							$perc=0;
						}
						else{
							$perc=0;
						$perc=(365 / round($min_bal/$avg_reward))*100 ;
						}
						$roi1=round($perc);
						$roi2=round($roi);						
					}
					$coins[$key]['roi1']=$roi1;
					$coins[$key]['roi2']=$roi2;
					
					$coins[$key]['apidata']=$apidata;
		}
		return $coins;
		
	}
	 /***
    *function to fetch top ten users having higehst number of mnodes
    *
    ***/
    private function topUsers()
    {
         $top_users = usermasternode::select('user_id','users.name',DB::raw('COUNT(*) AS occurrences'))
                                ->leftjoin('users', 'users.id', '=', 'usermasternodes.user_id')
							    ->groupBy('user_id','users.name')
							    ->orderByRaw('COUNT(*) DESC')
							    ->where('usermasternodes.step',5)
							    ->where('users.role', '!=','admin')
							    ->limit(10)
							    ->get();
		        return $top_users;			    
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

