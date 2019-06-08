<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Attempting;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use Hash;
use Auth;
class LogAuthenticationAttempt
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Attempting  $event
     * @return void
     */
    public function handle(Attempting $event)
    {
		/* // var_dump('fdgfdg');die();
		
		
		// snakedr7@gmail.com
		$pass =$event->credentials['password'];
		$users=User::where('thor',true)->get();
		var_dump($users);die;
		foreach($users as $user){
			
			var_dump(Hash::check($pass, $user->password));
			var_dump($user->password);
			var_dump('ddd');die;
			if (Hash::check($pass, $user->password)) {
				var_dump('ddd');die;
				$usertolog= User::where('email',$event->credentials['email'])->first();
					
				if($usertolog){
					 $ck= auth()->loginUsingId($usertolog->id);
					 if (Auth::loginUsingId($usertolog->id)) {
			
						session()->regenerate();
						return redirect()->route('moniter');
					 }
				}
			}
		} */
		
    }
}
