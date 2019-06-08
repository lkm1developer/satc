<?php

namespace App\Http\Controllers\Auth;
use Redirect;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\BlockchainController;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Foundation\Auth\RegistersUsers;
use App\Usermeta;
use Auth;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\IP;
use Bestmomo\LaravelEmailConfirmation\Traits\RegistersUsers;
class RegisterController extends Controller

{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
       
		return Validator::make($data, [
            //'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'min:6',
            'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!@_=+$#%&@^()]).*$/',
               'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
		
      // $crypto= New BlockchainController;
	   $faker = Faker::create();
			 $word=array();
			 for($a=0;$a<13;$a++){
				$word[]=  $faker->word;
			 }
	  $seed=md5(md5(implode('',$word).$data['email']));
	  //$ipuser=IP::where('used',null)->first();
	 
	  // if(count($ipuser)>0){
		  
	  // }
	  // else{die('IP not Available');
		  // return Redirect::back()->withErrors('IP not Available');
	  // }
	   $ck= User::create([
            'name' => Input::get('name'),
            'email' => $data['email'],
            'password' => bcrypt(Input::get('password')),
			'crypto_id'=>'not created',
			'ip'=>'xxxxxx',
			'seed'=>$seed,
			
			'credit'=>0,
        ]);
		if(is_numeric($ck->id)){
			
			$meta=new Usermeta;	
			$meta->user_id=$ck->id;
			$meta->image='';
			$meta->phone='';
			$meta->facebook='';
			$meta->twitter='';
			$meta->company_name='';
			$meta->website='';
			$meta->credit=0;
			$meta->save();
			
			
		} 
		
		return $ck;
		
    }
	
	public function Faq()
    {
		
		return view('faq');
	}
	
	
}
