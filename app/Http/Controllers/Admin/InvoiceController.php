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
use Maatwebsite\Excel\Excel;
use App\Exports\CollectionExport;
class InvoiceController extends Controller
{
    public function __construct()
    {
		 $this->middleware('auth');
    }
	private function Data($month= null){
		$current ='';
		if($month){
			$today=Carbon::createFromFormat('Y-m-d H:s:i',Carbon::parse($month) );
			$current=$month;
		} else {
			$today = Carbon::today();
		}
		   // $today = Carbon::today();
		   // $end =$today->endOfMonth();
		   // $start =$today->startOfMonth();
	   
	    $firstMNS= usermasternode::where('step',5)->orderBy('created_at','asc')->first()->created_at;
	    $rt=$ref=$from = Carbon::createFromFormat('Y-m-d H:s:i',$today );
	    $to = Carbon::createFromFormat('Y-m-d H:s:i', $today);
		$start=$from->startOfMonth()->format('Y-m-d H:s:i');
		$end =$ref->endOfMonth()->format('Y-m-d H:s:i');	   
		$Records = DB::table('deductions')
		 ->select(DB::raw('deductions.user_id, SUM(deductions.amount ) as amount, COUNT(deductions.user_id) as frequency , users.email'))
		 //->where('deductions.created_at', 'BETWEEN', $start,$end)
		 ->whereBetween('deductions.created_at', [ $start,$end])
		 ->groupBy('deductions.user_id')
		 ->join('users', 'users.id', '=', 'deductions.user_id')
		 // ->orderBy('deductions.amount', 'DESC')
		 ->get();			 
		$lastMonth =Carbon::parse($firstMNS);
		$months= array();
		while( Carbon::today()->addMonth()>$lastMonth){

			$months[]= $c=$lastMonth->format('M Y');
			$lastMonth=$lastMonth->addMonth();
			
		}
		if(!$current){
				$current=$c;
			}
		$data =array(
				'start'=>$start, 
				'end'=>$end,
				'users'=>$Records,
				'current'=>$current,
				'months'=>$months,
				);			 
		return $data;
	}
	public function Index(){
		$data = $this->Data();
		return view('admin.Invoice', compact('data'));
	}
	public function Month($month){
		$data = $this->Data($month);
		return view('admin.Invoice', compact('data'));
	}
	public function Export($month, $type){
		//return Excel::download(new CollectionExport(), 'export.xlsx');
		$data = $this->Data($month);
		$users= $data['users'];
		$excel = \App::make('excel');
		//return $excel->download(new CollectionExport($users), 'export.xlsx');
		if($type =='excel' ) {
			return $excel->download(new CollectionExport($users), 'Invoce-'.str_replace(' ','-',$month).'.xlsx');
		} else if($type =='pdf' )  {
			return $excel->download(new CollectionExport($users), 'Invoce-'.str_replace(' ','-',$month).'.pdf');
		}
		
		return view('admin.Invoice', compact('data'));
	}
	
}
