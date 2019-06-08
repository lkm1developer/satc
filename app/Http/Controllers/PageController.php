<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\usermasternode;
use App\allmasternode;
use App\User;
use Auth;
use App\IP;
use App\Srvr ;
use App\Serverfor;
use GuzzleHttp\Client;
class PageController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }
    public function index()
    {
        return view('home');
    }
    public function WelcomePage()
    {
		$coins= Allmasternode ::where('active',1)->select('logo')->get();
		$s=[];
		foreach($coins as $c){
			$s[]= $c->logo;	
		}
		// array_unique($s);
		// return response()->json(array_unique($s));
		// return response()->json($coins);
		// //array_unique($coins);
        return view('welcome')->with('coins',array_unique($s));
    }
	public function PReset()
    {
		
        return view('auth.passwords.reset');
	}
	public function makeipsix()
    {
		$others = Srvr::where('others',true)->get();
		foreach($others as $o){
				// $serverfor = new Serverfor;
				// $serverfor->coin_id = 22;
				// $serverfor->server_id = $o->id;
				// $serverfor->save();
				// $serverfor = new Serverfor;
				// $serverfor->coin_id = 0;
				// $serverfor->server_id = $o->id;
				// $serverfor->save();
				// $serverfor->coin_id = 24;
				// $serverfor->server_id = $o->id;
				// $serverfor->save();
		}
		// $ips = IP::all();
		// foreach($ips as $ip){
		// 	$iii =str_replace('[', '',$ip->ip);
			
		// 	$iii =str_replace(']', '',$iii);
			
		// 		IP::where('id',$ip->id)->update([
		// 		'ip4' => filter_var($ip->ip, FILTER_VALIDATE_IP,FILTER_FLAG_IPV4)? true: false,
		// 		'ip6' => filter_var($iii, FILTER_VALIDATE_IP,FILTER_FLAG_IPV6)? true: false,
		// 		]);
		// 	}
        
    }
	public function FreeIps()
    {
		
		$smart_serv=Srvr::where('smartcash', 1)->first();
		$smart_ip=IP::where('used',null)->where('server_id',$smart_serv->id)->get()->count();
		$nonsmart_serv=Srvr::where('smartcash', 0)->pluck('id')->toArray();	
		$other_ip=IP::where('used',null)->whereIn('server_id', $nonsmart_serv)->get()->count();
		return Response()->json([0=>['other_ip'=>$other_ip,'smart_ip'=>$smart_ip ]]);
        
    }
	public function Apidata()
	{
		$Allmasternode=Allmasternode::where('active',1)->with('MNS')->get();
		$Allmasternode1=Allmasternode::where('active',1)->get();
		$array=array();
		if($Allmasternode){
			foreach($Allmasternode as $key=>$coin){
				
							
				$Allmasternode1[$key]->total=count($coin->MNS);				
			}
		}
		return Response()->json($Allmasternode1);
	}
	public function CryptoHunterStats(Request $request)
	{

		//$Allmasternode=Allmasternode::whereIn('py_name',$request->coin)->get();
		$Allmasternode=Allmasternode::where('active',1)->get();
		$client = new \GuzzleHttp\Client();
		if($Allmasternode){
			foreach($Allmasternode as $key=>&$coin){
                unset($coin->wallet_address);
                unset($coin->kyd);
                unset($coin->active);
                unset($coin->payment_accepted);
                unset($coin->balance);
                unset($coin->tickerId);
                unset($coin->isFree);
                unset($coin->admin_wallet);
                unset($coin->timeoutgap);
                unset($coin->estmtime);
                unset($coin->port);
                unset($coin->updated_at);
                unset($coin->created_at);

                $apidata = $client->request('GET', 'http://192.168.0.200:3003/mn_stats_api/'.$coin->shortnm);
                $mn_data = json_decode($apidata->getBody(),true);
                $coin->mn_data='';
                if($mn_data):
                    if(is_array($mn_data)):
                        if(sizeof($mn_data)>0):
                            $data=$mn_data[0];
                            unset($data['detail_reward_24h']);
                            $coin->mn_data=$data;
                            $strip_comma = $coin->minbal;
                            if($data['avg_reward_24h']!=0 && is_numeric($strip_comma) && $strip_comma!=0):
                                $roi=$strip_comma/$data['avg_reward_24h'];
                                if($data['avg_reward_24h']==0 && $strip_comma==0){
                                    $perc=0;
                                }
                                else{
                                    $perc=0;
                                    $perc=(365 / round($strip_comma/$data['avg_reward_24h']))*100 ;
                                }
                                $coin->roi1=round($perc);
                                $coin->roi2=round($roi);
                            else:
                                $coin->roi1=0;
                                $coin->roi2=0;
                            endif;
                        endif;
                    endif;
                endif;

			}
		}
		return Response()->json($Allmasternode);
	}
   public function MasternodeStats()
	{
		$Allmasternode=Allmasternode::where('active',1)->with('MNS')->get();
		$array=array();
		if($Allmasternode){
			foreach($Allmasternode as $key=>$coin){
				$arra=array('name'=>$coin->name,'code'=>$coin->shortnm, 'mns'=>count($coin->MNS));					
				$array[]	=$arra;		
			}
		}
		return Response()->json($array);
	}
   
	public function Stats()
	{
		$Allmasternode=Allmasternode::where('active',1)->with('MNS')->get();
		$array=array();
		if($Allmasternode){
			foreach($Allmasternode as $key=>$coin){
				$arra=array('name'=>$coin->name,'code'=>$coin->shortnm, 'mns'=>count($coin->MNS));					
				$array[]	=$arra;		
			}
		}
		return Response()->json($array);
	}
   
	
	public function Homepage()
    {
		$coin=Allmasternode::where('coinname','MedicCoin')->first();
		$total_masternode=0;
		if(count($coin)>0){
		$total_masternode=Usermasternode::where('masternode_id',$coin->id)->get()->count();
		}
		
		 return View("welcome")->with(array('coin'=>$coin,'total_masternode'=>$total_masternode));
		//
	}
	public function Forgot()
		{ 
		return View("forgot")->with(array('get'=>true,'error'=>true));
		//return View("forgot");
		}
		
	public function ForgotEmail()
		{ 
			$email=Input::get('email');
			$user=User::where('email',$email)->first();
			if(count($user)==0){
				return View("forgot")->with(array('get'=>false,'error'=>true));
				
			}
			
				
			
			$msg = "Hi ".$user->name."\your Seed is <br>".$user->seed;

		

			// send email
			$ck=mail($user->email,"Seed",$msg);
			//var_dump($ck);die();
			return View("forgot")->with(array('get'=>false,'error'=>false));
		}
		
		
	public function Faq()
    {
		
		return view('faq');
	}
	
	public function CoinDashboard ()
    {
		$coin=Allmasternode::paginate(12);
		 return View("coindashboard")->with(array('coins'=>$coin));
		
	}
}
