<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\Request;
use Redirect;
use Faker\Factory as Faker;
use Auth;
use App\User;
use Bestmomo\LaravelEmailConfirmation\Traits\AuthenticatesUsers;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
	
	public function postLogin()
    {
		$seed=Input::get('seed');
        if(!$seed){
		//return Redirect::back()->withErrors(['msg', 'Seed  Required']);	
			
			return view('auth.login')->withErrors(['msg', 'Seed  Required']);
		}
		
		$user = User::where('seed', '=', $seed)->first();
		//Now log in the user if exists
		if ($user != null)
		{
			Auth::loginUsingId($user->id);
			 return redirect('/home');
		}
			
			return view('auth.login')->withErrors(['msg', 'User not Found']);
		//return Redirect::back()->withErrors('User not Found');
	}
	public function Masternode()
    {
		
		return view('welcome');
	}	
}
