<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use App\User;
use App\Usermeta;
use App\deduction;
use App\usermasternode;
use App\allmasternode;
//use App\Invoice as IModel;
use App\Invoice;
use Carbon\Carbon;
use App\Setting;
use DB;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\HostController;
use App\Http\Controllers\MailController;
use Log;
class Invoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthly:Invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'to send Invoice to users';

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
	
	private function Data(){
			$lastDay = Carbon::today()->startOfMonth()->addDays(-1);
			$firstDay = Carbon::today()->startOfMonth()->addDays(-1)->				startOfMonth();
		$start=$firstDay->format('Y-m-d H:s:i');
		$end =$lastDay->format('Y-m-d H:s:i');	   
		$Records = DB::table('deductions')
		 ->select(DB::raw('deductions.user_id, SUM(deductions.amount ) as amount, COUNT(deductions.user_id) as frequency , users.email'))
		 //->where('deductions.created_at', 'BETWEEN', $start,$end)
		 ->whereBetween('deductions.created_at', [ $start,$end])
		 ->groupBy('deductions.user_id')
		 ->join('users', 'users.id', '=', 'deductions.user_id')
		 // ->orderBy('deductions.amount', 'DESC')
		 ->first();	 
		return $Records;
	}
	
    public function handle()
    {	
		$data =$this->Data();
		//var_dump($data);die;
		$Setting= Setting::find(1);
		$month =Carbon::today()->addMonth(-1)->format('M Y');
		$rateInCoin =$Setting->rate;
		$rateInUSD =$Setting->hosting_rate;
		$usdToGbp =0.76;
			foreach ($data as $datum) {
				$InvoiceModel = new Invoice;
				var_dump($InvoiceModel);
				var_dump(New User);die;
				$InvoiceModel->user_id = $datum->user_id;
				$InvoiceModel->amount = $datum->amount;
				$InvoiceModel->frequency = $datum->frequency;
				$InvoiceModel->email = $datum->email;
				$InvoiceModel->month = $month;
				$usdTotal = round(((float)$datum->amount/(float)$rateInUSD)*100, 2);
				$gbpTotal = round($usdTotal*$usdToGbp,2);
				$InvoiceModel->usd = $usdTotal;
				$InvoiceModel->gbp = $gbpTotal;
				$InvoiceModel->save();
				
			}
		$this->info('Invoice Batch  completed ');
		 
	}
}
