<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\usermasternode;
use App\allmasternode;
use App\User;
use App\Usermeta;
use Auth;
use App\IP;
use Artisan;
class UpController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   
    public function SiteUp()
	{
		
		if((Auth::user())->role=='admin'){
			Artisan::call("up");
			 return redirect('/');
		}
	}
   
	}
