<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use App\User;
use App\Usermeta;
use  App\deduction;
use App\usermasternode;
use App\allmasternode;
use Carbon\Carbon;
use  App\Setting;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\HostController;
use App\Http\Controllers\MailController;
use Log;
class DailyDeduction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:deduction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deduct server fee ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
	public  function searchForId($id, $array) {
	   foreach ($array as $key => $val) {		 
		   if ($val['id'] === $id) {
			   return $key;
		   }
	   }
		return null;
	}
	 public function DollarToSATC()
    {	
			
			$now = new Carbon;
			$_24hrsprev	=$now->addMinutes(-5);
			$Setting=Setting::find(1);								
			if($Setting->rate_updated < $_24hrsprev){
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
				return round((float)$SATC_deduction,2);			
			}
			else{
				return $Setting->rate;
			}	
         
    } 
    public function handle()
    {	
		$p =storage_path('logs/laravel-'.date('Y-m-d',time()).'.log');
		$ck=chmod($p,0777);
		var_dump($ck);
	 	$rate=$this->DollarToSATC();//die;
		$Setting= Setting::find(1);
		$Setting->rate=$rate;
		$Setting->save();
		$total=0;
		$now = new Carbon;
		$_24hrsprev	=$now->addHours(-24);
		$toCompare = date("Y-m-d",time()).' 00:00:00';
		$masternodes=Usermasternode::where('step',5)->whereDate('deducted_on', '<', $toCompare)
					->get();				
		$counts=	count($masternodes);
		//$counts2=	count($masternodes2);
		$isFree = allmasternode::where('isFree',true)->pluck('id')->toArray();
		
		//var_dump(in_array('2',$isFree));die;
		$str= '	found masternode '.$counts;
		Log::info($str. ' @'.$now);
		if($counts>0) { 
			foreach ($masternodes as $a) {				
				echo ' looking for mastenode ID '.$a->id .' deducted last ';
				if(!in_array($a->masternode_id,$isFree)){
				//recheck it's deduction time
					$currentTime = new Carbon;
					$currentTime24hrsprev	=$currentTime->addHours(-24);
					echo '  '.$a->deducted_on.' < '.$currentTime24hrsprev;
					if($a->deducted_on<$currentTime24hrsprev){					
						echo ' lets cut bal ';				
						$usermeta=Usermeta::where('user_id',$a->user_id)->first();			
						if($usermeta) {
							echo $bal=$usermeta->balance;				
							$HostController =new HostController;
							if($bal<$rate){
								echo ' user have not sufficient balance ';
								$ThisUser=User::find($a->user_id);							
								if($ThisUser->expirey_date==null){
									$mail=new MailController;
									$sent=$mail->html_email($ThisUser);
									//echo $sent;	
									echo ' seding mail have not sufficient balance ';								
									$expirey_date=new Carbon();
									$expirey_date=$expirey_date->addDays(1);						
									$ThisUser->expirey_date=$expirey_date;
									$ThisUser->save();	
								} else {
									$date = new Carbon;								
									if($date > $ThisUser->expirey_date) { 
										Log::info( 'iam deleting masternode for user id '.$ThisUser->id);
										$DeductionController=new DeductionController;
										$DeductionController->DeleteNode($a);
										echo ' iam deleting masternode for user '.$ThisUser->id.' mastenode '.$a->id;
									}								
								}
								
							} else {
								echo ' user have bal cut the bal ';	
								$pre=$usermeta->balance;
								$post=$pre-$rate;
								$usermeta->balance=$post;
								$usermeta->masternode_count=$counts;
								$usermeta->deducted_on= Carbon::now()->toDateTimeString();
								$usermeta->save();	
								$total++;							
								$Deduction=new Deduction;
								$Deduction->user_id=$a->user_id;
								$Deduction->post_balance=$post?$post:0;
								$Deduction->pre_balance=$pre?$pre:0;
								$Deduction->amount=$rate;
								$Deduction->mid=$a->id;
								$Deduction->coin_id=$a->masternode_id;
								$Deduction->tx='';						
								$Deduction->save();						
								$msternd=usermasternode::find($a->id);
								$msternd->deducted_on=new Carbon;
								$msternd->save();
								echo ' ok bal deducted '. PHP_EOL;;
							}		   
					 
						}
					} else { echo ' skip this balance has already deducted or 24 hrs not completed '. PHP_EOL;;}
					//die;
				} else {echo 'skip this is free';}
			}
			if($total>0){
			//$HostController =new HostController;
			$echo = ' transfer coins '.$total*$rate.' for '.$total.' masternodes @ rate '.$rate. PHP_EOL;
			echo $echo;
			//$txHostController=$HostController->TransferHostingCharges($total*$rate);
			Log::info( $echo.' txHostController  '.$echo);
			}
			
		}
		$this->info('daily deduction completed ');
		 
	}
}
