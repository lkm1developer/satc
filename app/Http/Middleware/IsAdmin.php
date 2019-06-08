<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
		
		if(!($request->route()->getName()=='adminlogin'||$request->route()->getName()=='adminloginp')){
        if (!Auth::check()) {
            return redirect('/admin/login');
        }
		
		if ((Auth::user())->role!='admin') {
			Auth::logout();
            return redirect('/');
        }}
		//$debug = Config::set('app.debug', true);
		//var_dump($debug);true;
        return $next($request);
    }
}

