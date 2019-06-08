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
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\Controller;
class HostingController extends Controller
{
    
    public function __construct()
    {		
        $this->middleware('auth');
    }
	
    public function Index()
    {
		$c =new  Carbon;
		$settings=Setting::findOrFail(1);
		$monthlastday = new Carbon('last day of last month');;
		$lastHours= Deduction::
					where('created_at', '>=', $c::now()->subHour())
					->sum('amount');
		$today= Deduction::
					where('created_at', '>=', $c::today())
					->sum('amount');
		$yesterday= Deduction::
					whereBetween('created_at', array($c::today(), $c::yesterday()))
					->sum('amount');
		$week= Deduction::
					where('created_at', '>=',$c::today()->subWeek())
					->sum('amount');
		$month= Deduction::
					where('created_at', '>=',$monthlastday)
					->sum('amount');
		$lastWithdraw= Deduction::
					where('created_at', '>=', $settings->last_withdraw)
					->sum('amount');
		$DeductionAll= Deduction::sum('amount');
		$totalUser=User::all()->count();
		$totalmasternode=Usermasternode::all()->count();
		$totalcoins=Allmasternode::all()->count();
		
        //return response()->json
        return view('admin.hosting')->with
		 ([
			'settings'=>$settings,
			'totalUser'=>$totalUser,
			'totalmasternode'=>$totalmasternode,
			'totalcoins'=>$totalcoins,
			'lastHours'=>$lastHours,
			'today'=>$today,
			'yesterday'=>$yesterday,
			'week'=>$week,
			'lastWithdraw'=>$lastWithdraw,
			'DeductionAll'=>$DeductionAll,
			'monthlastday'=>$monthlastday,
			'month'=>$month,
			
		]);
    }
	
}
