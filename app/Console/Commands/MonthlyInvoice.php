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
use Mail;
class MonthlyInvoice extends Command
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
		$firstDay = Carbon::today()->startOfMonth()->
					addDays(-1)->startOfMonth();
					
		//$lastDay = Carbon::today()->endOfMonth();
		//$firstDay = Carbon::today()->startOfMonth();
					
					
		$start=$firstDay->format('Y-m-d H:s:i');
		$end =$lastDay->format('Y-m-d H:s:i');	   
		$Records = DB::table('deductions')
		 ->select(DB::raw('deductions.user_id, SUM(deductions.amount ) as amount, COUNT(deductions.user_id) as frequency , users.email, users.name'))
		 //->where('deductions.created_at', 'BETWEEN', $start,$end)
		 ->whereBetween('deductions.created_at', [ $start,$end])
		 ->groupBy('deductions.user_id')
		 ->join('users', 'users.id', '=', 'deductions.user_id')
		 // ->orderBy('deductions.amount', 'DESC')
		 ->get();	 
		return $Records;
	}
	
    public function handle()
    {	
		$data =$this->Data();
		//var_dump($data);die;
		$Setting= Setting::find(1);
		//$InvoiceDu= Invoice::find(39);
		//var_dump($InvoiceDu);die;
		$month =Carbon::today()->addMonth(-1)->format('M Y');
		$rateInCoin =$Setting->rate;
		$rateInUSD =$Setting->hosting_rate;
		$usdToGbp =0.76;
			foreach ($data as $datum) {
				$InvoiceModel = Invoice:: 
							 where('user_id',$datum->user_id)
							 ->where('month',$month)
							->first();
				if(!$InvoiceModel){
					$InvoiceModel = new Invoice;	
				}
				$InvoiceModel->user_id = $datum->user_id;
				$InvoiceModel->amount = $datum->amount;
				$InvoiceModel->frequency = $datum->frequency;
				$InvoiceModel->name = $datum->name;
				$InvoiceModel->email = $datum->email;
				$InvoiceModel->month = $month;
				$usdTotal = ((float)$rateInUSD *
							(float)$datum->amount) /
							(float)$rateInCoin 
							;
				$usdTotal = round($usdTotal,2);
				$gbpTotal = round($usdTotal*$usdToGbp,2);
				$InvoiceModel->usd = $usdTotal;
				$InvoiceModel->gbp = $gbpTotal;
				$InvoiceModel->save();
				$model =Invoice::find($InvoiceModel->id);
				// if($model->email=='piotr@dec.sx'){
					// $this->Email($model);
				// }
				// if($model->email=='lakhvinder.auspicioussoft@gmail.com'){
					// $this->Email($model);
				// }
				// echo 'am'.$model->amount;
				if($model->amount>0){
					
					$this->Email($model);
				}
			}
			
		
		$this->info('Invoice Batch  completed ');
		 
	}
	private function Email($model){
		
		$subject = 'Monthly Invoice of '.$model->month;
		$contact_company = 'Monthly Invoice';
		$email = $model->email;
		//$email = 'lakhvinder.auspicioussoft@gmail.com';
		Mail::send(['html' => 'email.invoice'], ['data' => $model], function($message) use ($email, $subject, $model)
		{
			$message->to($email, $model->name)->subject($subject);
		});
	}
}
