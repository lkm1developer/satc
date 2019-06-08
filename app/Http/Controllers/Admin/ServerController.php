<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Input;
use Session;
use Redirect;
use Illuminate\Http\Request;
use App\usermasternode;
use App\allmasternode;
use App\User;
use Auth;
use Validator;
use App\IP;
use App\Server;
use App\Serverfor;
use App\Meta;
use App\Sharednode;
use App\Reservation;
use Carbon\Carbon;
use Response; 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Controller;
class ServerController extends Controller
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
	public function server(){
		
		$Servers=Server::with('IPS')->get();
		$ipsLeft=IP::where('used',null)->count();	
		 return View("admin.server")->with('servers',$Servers)->with('ipsLeft',$ipsLeft);;
	}
	public function ServerDetail($id){
		$Server=Server::FindOrFail($id);
		$for = Serverfor::where('server_id',$id)->get()->pluck('coin_id');
		$coins = allmasternode::whereIn('id', $for)->get()->pluck('name')->toArray();
		$ips=IP::where('server_id',$id)->with('MNS')->get();		
		$ipsLeft=IP::where('server_id',$id)->where('used',null)->count();		
		return View("admin.serverSingle")->with('server',$Server)->with('ips',$ips)->with('ipsLeft',$ipsLeft)->with('dedicatedfor', $coins);
	}
	public function ServerADDIP($id,Request $request){
		$validator = Validator::make($request->all(), [
				'ipfile' => 'required|file|mimes:txt|max:2048'				
			]);

			if ($validator->fails()) {
				return Redirect::back()->withErrors($validator);
				
			} 
		 $image = $request->file('ipfile');
		$filename=time().'.'.$image->getClientOriginalExtension();
		$input['imagename'] = $filename;
		$destinationPath = public_path('/images');
		$image->move($destinationPath, $input['imagename']);
		$path= public_path('/images').'/'.$filename;
		 $file = fopen($path,"r");
		 $count=0;
		//$file = fopen($path."/list2.txt","r");
		$a=array();
		while(! feof($file))
		  {			  
		   $ex=explode('. ',fgets($file));		  
		   if(array_key_exists(1,$ex)){
		  $a[]=trim($ex[1]);
		   }		   
		  }
		
		
		fclose($file);
		
		$ips=$a;
		
		if(is_array($ips)){
		foreach($ips as $ip){
			$isexist=IP::where('ip',$ip)->first();			
			if(count($isexist)==0){
				$count++;
				$iii =str_replace('[', '',$ip);			
				$iii =str_replace(']', '',$iii);
				$ipi=new IP;
				$ipi->ip=$ip;			
				$ipi->server_id=$id;
				$ipi->ip4 = filter_var($ip, FILTER_VALIDATE_IP,FILTER_FLAG_IPV4)? true: false;
				$ipi->ip6 = filter_var($iii, FILTER_VALIDATE_IP,FILTER_FLAG_IPV6)? true: false;
				$ipi->save();
			}
		
		}
		}
		Session::flash('message', 'Added '.$count.' IPS'); 
		$Server=Server::FindOrFail($id);
		$ips=IP::where('server_id',$id)->with('MNS')->get();		
		$ipsLeft=IP::where('server_id',$id)->where('used',null)->count();		
		return View("admin.serverSingle")->with('server',$Server)->with('ips',$ips)->with('ipsLeft',$ipsLeft);
		

    
	}
	public function getDownload()
{
    //PDF file is stored under project/public/download/info.pdf
    $file= public_path(). "/images/sampleip.txt";

    $headers = array(
              'Content-Type: application/txt',
            );

    return Response::download($file, 'sampleip.txt', $headers);
}
	public function CreateServerPost(Request $request){
		$validator = Validator::make($request->all(), [
				'api_link' => 'required|url',				
				'ip' => 'required|ip|unique:server',				
				'localhost' => 'required|string'				
			]);

			if ($validator->fails()) {
				return Redirect::back()->withErrors($validator);
				
			} 
		$spMeta =$special = Meta::where('key','specialCoin')->first();	
		$special = json_decode($special->val);	
		$server=new Server;
		$server->ip=$request->get('ip');
		$server->localhost=$request->get('localhost');
		$server->api_link=$request->get('api_link');
		$server->main_ip=$request->get('ip');
	
	
		$ck=$server->save();	
		if($request->dedicated){
			foreach($request->dedicated as $d)
			{
				$thisCoin = allmasternode::where('id',$d)->first();
				if($thisCoin){
					$py_name = strtolower($thisCoin->py_name);
					if($py_name){
						if(!in_array($py_name, $special)){
							$spArray =$spMeta->val;
							$spArray =json_decode($spArray);
							$spArray[] =strtolower($thisCoin->py_name);						
							$spMeta->val = json_encode($spArray);
							$spMeta->save();	
						}
					}
				}
				 $serverFor = new Serverfor;
				 $serverFor->coin_id = $d;
				 $serverFor->server_id = $server->id;
				 $serverFor->save();
			}
	 }		
		Session::flash('message', 'Server Added'); 
		return redirect()->route('singleServer',$server->id);
		

    
	}
	public function DeleteServer($id)
	{
		$Serverfor=Serverfor ::where('coin_id', '!=',0)->distinct('coin_id')->pluck('coin_id')->toArray();
		if(count($Serverfor)>0){
			$coins = allmasternode::whereIn('id',$Serverfor)->get()->pluck('py_name')->toArray();
			$a =[];
			if(count($coins)>0){
				foreach($coins as $c){
					$a[]= strtolower($c);
				}
			}
			$spMeta =$special = Meta::where('key','specialCoin')->first();
			//$a =array_unique($a);
			$spMeta->val = json_encode($a);
			$spMeta->save();	
		}
		// return response()->json($Serverfor);
		// 	die;
		Serverfor ::where('server_id', $id)->delete();
		Server::destroy($id);
		// refresh special coins 
	
		Session::flash('message', 'Server Deleted'); 
		return redirect()->route('servr');
	}public function DelIP($server,$ip)
	{
		IP::destroy($ip);
		Session::flash('message', 'IP Deleted'); 
		return redirect()->back();
	}
	private function GetCoinAddress($coinid){
		$CoinM=Allmasternode::find($coinid);
		$app = app();
		$controller = $app->make('\App\Http\Controllers\\'. $CoinM->controller );
		$CoinController=$controller;//$CoinM->controller;
		return $CoinController->getNewAddress((Auth::user())->email);
	}
	public function CreateServer(){

		$special = Meta::where('key','specialCoin')->first();
		$coins = allmasternode::all();
		return view('admin.serverCreate')->with('coins',$coins)->with('special',$special);
	}
    
}
