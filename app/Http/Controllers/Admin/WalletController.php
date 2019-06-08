<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\allmasternode;
use App\User;
use Auth;
use App\Transfer;
use App\Srvr;
use App\Setting;
use Redirect;
use Session;
use Illuminate\Support\Facades\Input;
use phpseclib\Net\SSH2;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Log;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
class WalletController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
	
     
    public function Index()
    {
		$expiresAt = Carbon::now()->addMinutes(60);
		$coins= allmasternode::where('admin_wallet',true)->get();
		
		$Setting =  Setting::find(1);
		$satcPrice=$Setting->hosting_rate/$Setting->rate;
	 return view('admin.wallet')
	 ->with('user',Auth::user())->with('success',false)->with('coins',$coins)->with('satc_price',$satcPrice);
		
    }
	public function RefreshBal()
	{
		$coin = Input::get('coin');
		$output = $this->Bal($coin);
		if((float)($output) > 0){
			allmasternode::where('py_name',$coin)->update(['balance'=>$output]);
		}
		return response()->json(['status'=>true, 'data'=>$output]);	
		
	}
	public function Bal($coin)
	{
		
		$server= Srvr::find(10);
		$command = 'cd /home/admin && python balance.py '.$coin;
		$ssh = new SSH2($server->localhost);			
		if (!$ssh->login($server->ssh_user, $server->ssh_pass))	{
			response()->json(['status'=>false]);
		}
        $output = $ssh->exec($command);
		return $output;
		
	}
	public function Send()
    {
		$coin = Input::get('coin');
		$amount = Input::get('amount');
		$address = Input::get('address');
		$pass = Input::get('pass');
		$time = Input::get('time');
		$checkBal = $this->Bal($coin);
		$adminLog = new Logger('Transfer');
		$adminLog->pushHandler(new StreamHandler(storage_path('logs/admin'.date('y-m-d',time()).'.log')), Logger::INFO);
		$log='trying to send coin by admin coin '.$coin. ' amount '.$amount.' address '.$address.' checkBal'.$checkBal;
		$adminLog->info('info', [$log]);
		if($amount > (float)($checkBal) ){
			$adminLog->info('error', [$log.' failed NotsuffiecientBalance'] );
			response()->json(['status'=>false,'data'=>'Not suffiecient Balance']);
		}
		$server= Srvr::find(10);
		
//		$command = 'cd /home/admin && python withdraw.py '.$coin.' '.$address.' '.$amount;
		//python walletpassphrase.py passphrase time && python withdraw.py symbol address amount
		//python walletpassphrase.py SYMBOL passphrase time && python withdraw.py SYMBOL address amount
		 $command = 'cd /home/admin && python walletpassphrase.py '.$coin.' '.$pass.' '.$time.' && python withdraw.py '.$coin.' '.$address.' '.$amount;
		
		$ssh = new SSH2($server->localhost);
		//$ssh->setTimeout(150);		
		if (!$ssh->login($server->ssh_user, $server->ssh_pass))	{
			response()->json(['status'=>false]);
		}
		$adminLog->info('command',[' exec command '.$command] );
        $output = $ssh->exec($command);
		$adminLog->info('output',[' exec command response '.$output] );
		if (strpos($output, 'Invalid')){
			
			response()->json(['status'=>false,'data'=>'Invalid address']);
		}
		//var_dump($output);
		if($output){
			$transfer = new Transfer;
			$transfer->coin = (float)$coin;
			$transfer->address = $address;
			$transfer->amount = (float)$amount;
			$transfer->hash = $output;
			$transfer->prebal =(float) $checkBal;
			$transfer->postbal = (float)($checkBal)-(float)($amount);
			$transfer->save();
		}
		return response()->json(['status'=>true, 'data'=>str_replace('done','',$output)]);
	}
	
   
}
