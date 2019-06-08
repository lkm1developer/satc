<?php
namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\usermasternode;
use App\allmasternode;
use App\deduction;
use App\User;
use Auth;
use App\Usermeta;
use App\Setting;
use App\IP;
use Mail;
use Carbon\Carbon;
use Redirect;
use Validator;
use Session;
use Artisan;
use Response;
use DB;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\Controller;
class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
	
     
    public function index()
    {
		
		$totalUser=User::all()->count();
		$totalmasternode=Usermasternode::all()->count();
		$totalcoins=Allmasternode::all()->count();
		$settings=Setting::findOrFail(1);
         return view('admin.home')->with(['settings'=>$settings,'totalUser'=>$totalUser,'totalmasternode'=>$totalmasternode,'totalcoins'=>$totalcoins]);
    }
	public function SiteDown(Request $request)
	{
		Setting::where('id',1)->update(['downtill'=>$request->get('downtill')]);	
			Artisan::call("down");
			Session::flash('message', 'maintenance mode on '); 
			 return redirect('/admin/home');
		
	}
    public function SiteUp()
	{	Artisan::call("up");
	Session::flash('message', 'Website live now'); 
		return redirect('/admin/home');
		
	}
	 public function DollarToSATC()
    {	
			
				$Setting=Setting::find(1);	
				$serverRate=Setting::find(1)->hosting_rate??0.13;
				$client = new \GuzzleHttp\Client();       
				$res = $client->request('GET', 'https://graviex.net//api/v2/tickers/satcbtc.json');        
				$coin_exchange_rates = json_decode($res->getBody(),true);
				$one_BTC_Eq_Satc=$coin_exchange_rates['ticker']['last'];
				$BTC_IN_USD = $client->request('GET', 'https://api.coinbase.com/v2/prices/spot?currency=USD'); 
				$BTC_IN_USD_Arr = json_decode($BTC_IN_USD->getBody(),true);
				if(!is_array($BTC_IN_USD_Arr)){die('conversionfail');}
				$one_BTC_in_USD=$BTC_IN_USD_Arr['data']['amount'];
				$SATC_deduction=$serverRate/($one_BTC_in_USD*$one_BTC_Eq_Satc);           
				$Setting->rate_updated=new Carbon;	
				$Setting->rate=round((float)$SATC_deduction,2);	
				$Setting->save();	
						
			
    }
	public function UpdateSettings(Request $request)
    {
		//var_dump($request->all());die;
		$validator = Validator::make($request->all(), [
				'admin_address' => 'required|min:20|max:255',
				'hosting_rate' => 'required|numeric'
			]);

			if ($validator->fails()) {
				return Redirect::back()->withErrors($validator);
				
			} else {
				
			Setting::where('id',1)->update([
							'admin_address'=>$request->get('admin_address'),
							'hosting_rate'=>$request->get('hosting_rate'),
							]);
		$this->DollarToSATC();					
		$totalUser=User::all()->count();
		$totalmasternode=Usermasternode::all()->count();
		$totalcoins=Allmasternode::all()->count();
		$settings=Setting::findOrFail(1);
		Session::flash('message', 'Settings updated'); 
         return view('admin.home')->with(['settings'=>$settings,'totalUser'=>$totalUser,'totalmasternode'=>$totalmasternode,'totalcoins'=>$totalcoins]);
			}
    } 
	 public function Users()
    {
		
		 $users=User::latest()->with('Usermeta')->with('masternode')->paginate(10000);
	
         return view('admin.users')->with('users',$users);
    } 
	 public function User($id)
	{
		$allmasternode=Allmasternode::all()->pluck('coinname','id');
		$user=User::where('id',$id)->with('Usermeta')->with('masternode')->first();
		
         return view('admin.single_user')->with('user',$user)->with('allmasternode',$allmasternode);
    }
	 public function SuspendUser($id)
	{
		$user=User::findOrfail($id);
		$user->active=0;
		$user->save();
		Session::flash('emailsent', 'user has been s');
		return redirect('/admin/user/'.$id);
		
    }
	 public function ActivateUser($id)
	{
		$user=User::findOrfail($id);
		$user->active=1;
		$user->save();
		Session::flash('emailsent', 'user has been activated');
		return redirect('/admin/user/'.$id);
		
    }
	 public function MailUser($id)
	{
		$user=User::findOrfail($id);
		 $data =array('name'=>$user->name,'email'=>$user->email);
      Mail::send('adminmail', $data, function($message) use ($user){
         $message->to($user->email, 'MedicCoin information')->subject
            ('Notice');
         $message->from(env('MAIL_FROM_ADDRESS'),env('MAIL_FROM_NAME'));
      });
		Session::flash('emailsent', 'Email  has been sent to user');
		return redirect('/admin/user/'.$id);
		
    }
	 public function DeleteUser($id)
	{
		$user=User::findOrfail($id);
		$masternode=Usermasternode::where('user_id',$id)->get();
		if($masternode){
			$DeductionController = new DeductionController;
			foreach($masternode as $node){
				$DeductionController->DeleteNode($node);
			}
		}
		User::destroy($id);
		Session::flash('DeleteUser', 'User  has been deleted');
		return redirect('/admin/users');	
    }
	 public function TransactionsUser($id)
	{ 	
		$Setting= Setting::find(1);
		$allmasternode=Allmasternode::all()->pluck('coinname','id');
		$user=User::where('id',$id)->with('Usermeta')->with('masternode')->first();
		$Deduction=Deduction::where('user_id',$id)->latest()->paginate(10000);//echo '<pre>';var_dump($user);die;
         return view('admin.TransactionsUser')->with('deductions',$Deduction)->with('user',$user)->with('Setting',$Setting);;
		
		
    } 
	public function Transactions()
	{
		$allmasternode=Allmasternode::all()->pluck('coinname','id');
		$Deduction=Deduction::with('user')->latest()->paginate(10000);
		//echo '<pre>';var_dump($user);die;
         return view('admin.Transactions')->with('deductions',$Deduction)->with('allmasternode',$allmasternode);
		
		
    }
	
	public function MasternodeUser($userid,$node)
    {
		$user=User::find($userid);
		
		
		$usermasternode=usermasternode::findorfail($node);
		if(count($usermasternode)>0){
			//return response()->json($usermasternode);	
        return view('admin.MasternodeUser')->with('usermasternode',$usermasternode)->with('user',$user);
		}
		return redirect()->route('adminuser');
        //return view('view-detail');
    }
	public function MakeFreeIPS(){
		$count =0;
		$all= IP::where('used',true)->get()->pluck('id');
		
		foreach($all as $ip){
			$hasNode = usermasternode::where('ips_id',$ip)->get()->count();
			
			if(!$hasNode){
				//var_dump($hasNode.$ip);
				IP::where('id',$ip)->update(['used'=>null,'user_id'=>null]);
				$count++;
			}
			
		}
		Session::flash('message', $count .' made IP\'s free');
		return redirect::back();	
		
	}
	
}
