<?php

namespace App\Http\Controllers;

use App\deduction;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\User;
use App\Usermeta;
use App\Http\Controllers\MedicController;


use App\Transaction;
use App\Http\Controllers\HostController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\SatoshiController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use Auth;
use Redirect;
use App\usermasternode;
use App\allmasternode;
use App\port;
use App\IP;

use Log;


use Carbon\Carbon;
class DeductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
			$serverRate=0.30;
			 $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', 'https://api.crypto-bridge.org/api/v1/ticker');        
            $coin_exchange_rates = json_decode($res->getBody(),true);
			//var_dump(gettype($coin_exchange_rates));die;
			$satckey=$this->searchForId('SATC_BTC',(array)$coin_exchange_rates);
			$one_BTC_Eq_Satc=$coin_exchange_rates[$satckey]['last'];
			
			//var_dump($one_BTC_Eq_Satc);//die;
			$BTC_IN_USD = $client->request('GET', 'https://api.coinbase.com/v2/prices/spot?currency=USD'); 
				
            $BTC_IN_USD_Arr = json_decode($BTC_IN_USD->getBody(),true);
			if(!is_array($BTC_IN_USD_Arr)){die('conversionfail');}
			//echo '<pre>';
			//var_dump($BTC_IN_USD_Arr);die;
			$one_BTC_in_USD=$BTC_IN_USD_Arr['data']['amount'];	
			
			  $SATC_deduction=((1/$one_BTC_in_USD)*$one_BTC_Eq_Satc*$serverRate);
            return round((float)(substr($SATC_deduction,0,3)));
			
         
    } 
    public function DollarToMedic()
    {
			 $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', 'https://api.coinmarketcap.com/v1/ticker/mediccoin');        
            $coin_exchange_rates = json_decode($res->getBody());
            $onion_price_original =$coin_exchange_rates[0]->price_usd;
			$charges=0.45;
			if($onion_price_original){
				return round(($charges/$onion_price_original),0);
			}
			else{
				die('Error In Api');
			} 
         
    }

  
   public function DeleteNode($masternode)
   {
	  // Log::info($masternode->id.' err in stopping StartNode');die();
	   $nodes=Usermasternode::where('id',$masternode->id)->first();
	   if(count($nodes)>0)
	   {
		  
			echo ' in deduction controller ';
			//$CoinM=Allmasternode::find($masternode->masternode_id);
			// $app = app();
			// $controller = $app->make('\App\Http\Controllers\\'. $CoinM->controller );
			$controller = new SatoshiController($masternode->masternode_id);
			$CoinController=$controller;

			$CoinController->Delete($masternode);
			 }
		 
		
	 

   }
}
