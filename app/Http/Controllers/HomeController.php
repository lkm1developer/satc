<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\usermasternode;
use App\allmasternode;
use App\User;
use App\Usermeta;
use Auth;
use App\IP;
use App\Apihosted;
use App\Apiinfo;
use App\Srvr;
use App\Setting;
use Artisan;
use DB;
use App\Reward;
use App\Allreward;
use App\deduction;

use App\Http\Controllers\SatoshiController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\BlockchainController;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('auth');
    }
	public function SiteDown()
	{
		
		if((Auth::user())->role=='admin'){
			Artisan::call("down");
			 return redirect('/');
		}
	}
	public function EnableNotification(Request $request)
	{
		
		$ck=User::where('id',Auth::id())->update(['notification'=>$request->get('data')=='true'?true:false]);
		return response()->json($ck);
		
	}
    public function SiteUp()
	{
		
		if((Auth::user())->role=='admin'){
			Artisan::call("up");
			 return redirect('/');
		}
	} 
	public function HostingCharges()
	{
		$deduction= deduction::where('user_id',Auth::id())->with('coin')->with('masternode')->latest()->paginate(500);
		//return response()->json($deduction);
		return view('hostingcharges')->with('deductions',$deduction);
		
	}
	//this function used for wordpress site api
	public function CustomTable()
	{
		$Allmasternode=Allmasternode::where('active',1)->with('MNS')->get();
		$total=0;
		if($Allmasternode){
			foreach($Allmasternode as $coin){
				$coindata=	Apihosted::where('coin', $coin->id)->first();
				if(!$coindata){
					$coindata=new Apihosted;
				}
				$coindata->coin=$coin->id;
				$coindata->hosted_mn=count($coin->MNS);
				$total=$total+count($coin->MNS);
				$coindata->save();
			}
		}
		$totalhosted=	Apiinfo::find(1);
		if(!$totalhosted){
			$totalhosted=new Apiinfo;
		}				
		$totalhosted->total_hosted_mn=$total;				
		$totalhosted->save();
		
	}
    public function Reward ($masternode,$paid){
		$hasRecord = Reward::where('usermasternode_id',$masternode->id)->first();
		if(count($hasRecord)==0) {
			$newReward = new Reward;
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
				$newReward =  Reward::find($hasRecord->id);
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
     public function Moniter($coin=null)
    {
		
		$Setting=Setting::find(1);
		//var_dump($DollarToSATC);die;
		$selected_coin=$coin;
		
		$user=Auth::user();
		$id=$user->id;
		$notification= new NotificationController;
		// find user ->his masternode ->masternode details
		$usermasternode=User::find($id)->Usernode()->with('masternode')->paginate(1000);		
        $Servers=Srvr::all();
		$CoinApiData=array();
		$CoinApiDataPaid=array();
		$CoinApiDataSEEN=array();
		if($Servers){		
		foreach($Servers as $Server){			
			$CoinApiData[$Server->id]=json_decode(file_get_contents($Server->api_link));	
		}
		}
		$coinUsed=Usermasternode::groupBy('masternode_id')->where('user_id',Auth::id())->pluck('masternode_id')->toArray();	
		$allmasternode=count($coinUsed)>0?Allmasternode::whereIn('id',$coinUsed)->get():null;			
		
		$CoinApiDataPaid=array();
		if($allmasternode){		
		foreach($allmasternode as $coin){			
			$CoinApiDataPaid[$coin->id]=json_decode(file_get_contents('http://192.168.0.200:3006/mn_paid_api/'.$coin->shortnm));
			//$CoinApiDataSEEN[$coin->id]=json_decode(file_get_contents('http://79.137.70.128:3009/mn_lastseen_api/'.$coin->shortnm));		
		}
		}	
			
		//echo '<pre>';
		// return response()->json($CoinApiData);//die;
		if(count($usermasternode)>0){
			foreach($usermasternode as $keyy=>$masternode){
				if($masternode->step==5){
				if(!$masternode->server_id){
					//return response()->json($masternode);//die;
					$this_server=IP::find($masternode->ips_id);					
					$this_node=Usermasternode::find($masternode->id);
					$this_node->server_id=$this_server->server_id;
					$this_node->save();
					$masternode->server_id=$this_server->server_id;
				}
				if(array_key_exists($masternode->server_id,$CoinApiData)){					
					$found=array();				
					if($CoinApiData[$masternode->server_id]){
						foreach($CoinApiData[$masternode->server_id] as $key=>$val){
							if(($masternode->id==$val->wallet_id)){
								if(!$masternode->wallet_addr){
									$this_node=Usermasternode::find($masternode->id);
									$this_node->wallet_addr=$val->addr;
									$this_node->save();
									$masternode->wallet_addr=$val->addr;
								}	
								$usermasternode[$keyy]->found=$val;
								//$notification->NodeStatus($masternode,$val);
							}
						}
					}
				}
				if($CoinApiDataPaid){
					if(array_key_exists($masternode->masternode_id,$CoinApiDataPaid)){	
						foreach($CoinApiDataPaid[$masternode->masternode_id] as $paidkey=>$paidval){				 
							if($masternode->wallet_addr){					
								if($masternode->wallet_addr==$paidval->wallet_addr){
									$usermasternode[$keyy]->foundpaid=$paidval;
									//$notification->Notifications($masternode,$paidval);
								}
							}
						}
					 
					}
				}
				// if($CoinApiDataSEEN){
					// if(array_key_exists($masternode->masternode_id,$CoinApiDataSEEN)){	
						 // foreach($CoinApiDataSEEN[$masternode->masternode_id] as $SEENpaidkey=>$SEENpaidval){				 
								// if($masternode->wallet_addr){									
									 // if($masternode->wallet_addr==$SEENpaidval->wallet_addr){								
										// $usermasternode[$keyy]->foundpaidSEEN=$SEENpaidval;;
									// }
									
								// }
						 // }
					 
					// }
				// }
				
				}
				
			}			
		
		}
		$PC = new ProfileController;
		$smartip= $PC->GetDesiredIP('SMART',true);
		$satcip=$PC->GetDesiredIP('SATC',true);	
		$xdnaip=$PC->GetDesiredIP('XDNA',true);	
		$restip=$PC->GetDesiredIP('others',true);
		$allmasternode=Allmasternode::where('active',1)->get();
		$users_mns = usermasternode::where('user_id',$id)->where('step',5)->count();
		$rmng_days= $this->getDays();
		foreach($usermasternode as &$n){
			if (!filter_var($n->ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
				$hasBracket = strpos($n->ip, '[');
				if($hasBracket<1)	{
					$n->ip = '['.$n->ip.']';
				}
			} 
		}
		// return response()->json($usermasternode);
         return view('moniter')
		 ->with('user',$user)
		 ->with('usermasternode',$usermasternode)
		 ->with('allmasternode',$allmasternode)
		 ->with('Setting',$Setting)
		 ->with('days',$rmng_days)
		 ->with('smartip',$smartip)
		 ->with('xdnaip',$xdnaip)
		 ->with('satcip',$satcip)
		 ->with('restip',$restip)
		 ->with('total_mns',$users_mns)
		 ->with('selected_coin',$selected_coin);
    }
	  public function view($id)
    {
		$user=Auth::user();
		$userid=$user->id;
		$foundpaid=new \stdClass();;
		$found=new \stdClass();;
		$usermasternode=User::find($userid)->Usernode()->where('id',$id)->where('user_id',$userid)->with(['masternode'])->first();;
		$reward= Reward::where('usermasternode_id',$id)->first();	
		$data=null;
		if(count($usermasternode)>0){
		$coin=Allmasternode::find($usermasternode->masternode_id)->shortnm;	
		$serverApiData= Srvr::find($usermasternode->server_id);
		if(count($serverApiData)>0){
			$serverApiLink= Srvr::find($usermasternode->server_id)->api_link;
			$data=json_decode(file_get_contents($serverApiLink));
		}
		
		$price=json_decode(file_get_contents('http://192.168.0.200:3003/mn_stats_api/'.$coin));
		
		$DataPaid=json_decode(file_get_contents('http://192.168.0.200:3006/mn_paid_api/'.$coin));
		$found=new \stdClass();;
		$nodeServerData=array();
		
			$ip=IP::where('id',$usermasternode->ips_id)->pluck('server_id')->first();
			
			if($ip){
				$link=Srvr::where('id',$ip)->pluck('api_link')->first();
				
				if($link){
					$ServerData=json_decode(file_get_contents($link));
					if($ServerData){
						foreach($ServerData as $Serverkey=>$Serverval){
							
							if(($usermasternode->id==$Serverval->wallet_id)){
								if(!$usermasternode->wallet_addr){
									$this_node=Usermasternode::find($usermasternode->id);
									$this_node->wallet_addr=$Serverval->addr;
									$this_node->save();
									$usermasternode->wallet_addr=$Serverval->addr;
								}	
								$nodeServerData=$Serverval;
							}
						}
					}
						
				}
			}
				
		
		if($data){
			foreach($data as $key=>$val){
				if($usermasternode->id==$val->wallet_id){
					$found=$val;
					foreach($DataPaid as $paidkey=>$paidval){
						if(($val->addr==$paidval->wallet_addr)){
							$foundpaid=$paidval;
						}
					}
				}
			}
		}
		// return response()->json([
		// 'usermasternode'=>$usermasternode,'nodeServerData'=>$nodeServerData,
		// 'user'=>$user,'found'=>$found,'foundpaid'=>$foundpaid,'reward'=>$reward,'price'=>$price
		// ]);
		if (!filter_var($usermasternode->ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
			$hasBracket = strpos($usermasternode->ip, '[');
			if($hasBracket<1)	{
				$usermasternode->ip = '['.$usermasternode->ip.']';
			}
		} 
		
        return view('view-detail')->with('usermasternode',$usermasternode)->with('nodeServerData',$nodeServerData)
		->with('user',$user)->with('found',$found)->with('foundpaid',$foundpaid)->with('reward',$reward)->with('price',$price);
		}
		return redirect()->route('moniter');
        //return view('view-detail');
    }
    public function Dashboard()
    {
		$user=Auth::user();
		$id=$user->id;
		//find user ->his masternode ->masternode details
		$usermasternode=User::find($id)->Usernode()->with(['masternode'])->paginate(1000);;
		$usermeta=Usermeta::where('user_id',$id)->first();;
		/*******need to show no of days remaining to host all mns for current user ********/
         $users_mns = usermasternode::where('user_id',$id)->where('step',5)->count();
         $var=$this->getDays();
		/*******end of script********/
        $allmasternode=Allmasternode::all();
        return view('home')->with('user',$user)->with('usermasternode',$usermasternode)->with('allmasternode',$allmasternode)->with('usermeta',$usermeta)->with('days',$var)->with('total_mns',$users_mns);
    }

    /**********************************************
    *get days remaining to host mns for current user
    ***********************************************/
    private function getDays(){
    	$user=Auth::user();
		$id=$user->id;
		$Setting=Setting::find(1);
		$per_day=$Setting->rate;
		$usermeta=Usermeta::where('user_id',$id)->first();;
		$users_mns = usermasternode::where('user_id',$id)->where('step',5)->count();
		$total_a_day= $users_mns * $per_day ;
		if($total_a_day>0){
			$days_rmg=$usermeta->balance/$total_a_day;
			$rounded = floor($days_rmg*100)/100;
			$var = (int)$rounded; // 252
			return $var;
		} else {
			return 'NA';
		}
		
		
    }

    public function coinpage()
    {
		
		$de_object = new BlockchainController;
          $satc_mns_data=$de_object->getMnData();
		 
       //return response()->json($satc_mns_data);
        return view('coin-page')->with('satc_mns_data',$satc_mns_data);
    }
	public function IP(){
		 $path= __DIR__;
		 $file = fopen($path."/list.txt","r");
		//$file = fopen($path."/list2.txt","r");
		$a=array();
		while(! feof($file))
		  {			  
		   $ex=explode('. ',fgets($file));
		   //$ex=explode('.	',fgets($file));
		  // print_r($ex);
		   if(array_key_exists(0,$ex)){
		  $a[]=trim($ex[0]);
		   }		   
		  }
		fclose($file);
		//die();
		//$ips=array('173.211.88.3','173.211.88.4');
		$ips=$a;
		if(is_array($ips)){
		foreach($ips as $ip){
			$isexist=IP::where('ip',$ip)->get();
			if(count($isexist)==0){
				$ipi=new IP;
				$ipi->ip=$ip;			
				$ipi->server_id=8;
				$ipi->save();
			}
		
		}
		}

		}
	}
