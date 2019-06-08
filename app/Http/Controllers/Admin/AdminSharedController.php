<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\usermasternode;
use App\allmasternode;
use App\User;
use Auth;
use App\IP;
use App\Sharednode;
use App\Reservation;
use Carbon\Carbon; 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Controller;
class AdminSharedController extends Controller
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
	public function Shared(){
		
		$Sharenode=Sharednode::with('Coin')->with('usermasternode')->latest()->paginate(12);
		
		 return View("admin.shared")->with('Sharenodes',$Sharenode);
	}
	public function SharedDeatail($id){
		$Sharenode=Sharednode::FindOrFail($id);
		$now=new Carbon;
		$freeslot=Reservation::where('sharenode_id',$id)
					->where('deposited',0)
					->where('reserved_till','<', $now)
					->sum('slot');
		$sharenode=$old=Sharednode::findOrFail($id);		
		$sharenode->reserved=$old->reserved	-$freeslot;	
		$sharenode->save();
		$todel=Reservation::where('sharenode_id',$id)
					->where('deposited',0)
					->where('reserved_till','<', $now)
					->get()->pluck('id');
			
		if(count($todel)){
			//var_dump($allmasternode_id,$slot,$todel);		
		 Reservation::destroy($todel);
		}
		
		$Sharenode=Sharednode::where('id',$id)->with('reservation')->get();
		// $Sharenode=Sharednode::FindOrFail($id);
		//echo '<pre>';var_dump($Sharenode);die;
		 return View("admin.sharedSingle")->with('Sharenodes',$Sharenode[0]);
	}
	public function CreateShared($id){
		$Usermasternode=Usermasternode::where('sharednode_id',$id)->latest()->first();
		if(count($Usermasternode)>0){
			 return	View("admin.sharedCreate")->with('masternode',$Usermasternode);
		}
		$Sharednode=Sharednode::findOrFail($id)->with('Coin')->first();;
		$ProfileController=new ProfileController;
		$InitMasternode=$ProfileController->InitMasternodeAdmin($Sharednode->Coin->id,$Sharednode->id,$Sharednode->Coin->minbal,time(),0);
		
		if(!$InitMasternode){
			Session::flash('message', 'IP is not available '); 
		
		}
		$Usermasternode=Usermasternode::where('sharednode_id',$id)->latest()->first();
		if(count($Usermasternode)>0){
			 return	View("admin.sharedCreate")->with('masternode',$Usermasternode);
		}
	
		
		
	
	
	}
	private function GetSharenode($allmasternode_id,$slot){
		
		$old=$sharenode=Sharednode::where('allmasternode_id', $allmasternode_id)->latest()->first();
		if(!count($sharenode)){
			$sharenode=new Sharednode;
			$sharenode->allmasternode_id=$allmasternode_id;
			$sharenode->reserved=$slot;
			$sharenode->deposited=0;
			$sharenode->address=null;
			$sharenode->completed=0;
			$sharenode->save();
			return $sharenode->id;
		}
		$now=new Carbon;
		$freeslot=Reservation::where('sharenode_id',$sharenode->id)
					->where('deposited',0)
					->where('reserved_till','<', $now)
					->sum('slot');
				
		$sharenode->reserved=$old->reserved	-$freeslot;	
		$sharenode->save();
		$todel=Reservation::where('sharenode_id',$sharenode->id)
					->where('deposited',0)
					->where('reserved_till','<', $now)
					->get()->pluck('id');
			
		if(count($todel)){
			//var_dump($allmasternode_id,$slot,$todel);		
		 Reservation::destroy($todel);
		}		
				
		$sharenode=Sharednode::find($old->id);
		if($sharenode->reserved+$slot>20){
			
			$sharenode=new Sharednode;
			$sharenode->allmasternode_id=$allmasternode_id;
			$sharenode->reserved=$slot;
			$sharenode->deposited=0;
			$sharenode->address=null;
			$sharenode->completed=0;
			$sharenode->save();
			return $sharenode->id;
		}
		
			$sharenode->reserved=$sharenode->reserved+$slot;
			$sharenode->save();
			return $sharenode->id;
	}
	private function GetCoinAddress($coinid){
		$CoinM=Allmasternode::find($coinid);
		$app = app();
		$controller = $app->make('\App\Http\Controllers\\'. $CoinM->controller );
		$CoinController=$controller;//$CoinM->controller;
		return $CoinController->getNewAddress((Auth::user())->email);
	}
	public function AfterReservation(){
		Reservation::where('user_id',Auth::id())->get();
	}
    
}
