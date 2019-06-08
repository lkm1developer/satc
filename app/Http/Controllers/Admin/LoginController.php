<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
//use Bestmomo\LaravelEmailConfirmation\Traits\AuthenticatesUsers;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\Request;
use Redirect;

use Auth;
use App\User;
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

    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
	 public function Login(){
		
		 if(Auth::check()){
			return redirect('/admin/home');
		 }
		return view('admin.login');
		 
	 }
	
	public function Authenticate()
    {
	
		$email=Input::get('email');
		$password=Input::get('password');
       if (Auth::attempt(['email' => $email, 'password' => $password, 'valid' => 1,'role'=>'admin'])) {
            // Authentication passed...
            return redirect('/admin/home');
        }
		return redirect('/admin/login')->with('errors','Login credentials invalid');
	}
	
}
