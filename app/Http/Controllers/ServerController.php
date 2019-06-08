<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\usermasternode;
use App\allmasternode;
use App\Server as servertable;
use App\User;
use App\Usermeta;
use Auth;
use App\IP;
use JsonRPC\Client;
use JsonRPC\Server;
use phpseclib\Net\SSH2;
use App\Setting;
class ServerController extends Controller
{
   
    public function __construct()
    {
        //$this->middleware('auth');
		// root@ns3072186:/# df /var/www/html --output=source,used,avail -h
		// Filesystem      Used Avail
		// /dev/md3        7.7G   11G
		// root@ns3072186:/# df /var/www/html --output=source,used,avail
		// Filesystem        Used    Avail
		// /dev/md3       7986664 10999180
		// root@ns3072186:/# df /var/www/html --output=source,used,avail
		// Filesystem        Used    Avail
		// /dev/md3       7968980 11016864
		// root@ns3072186:/# df /var/www/html --output=source,used,avail -h
		// Filesystem      Used Avail
		// /dev/md3        7.6G   11G
		// root@ns3072186:/#

    }
	private function SSH()
	{
		//$host = $_ENV['CR_host'];
	//	$username = $_ENV['CR_username'];
		//$password = $_ENV['CR_password'];
		$appSettings= Setting::find(1);
			$username = $appSettings->ssh_user;
			$password = $appSettings->ssh_pass;;
			 $ssh = new SSH2($appSettings->plateform_server);			
				if (!$ssh->login($username, $password)) 
				{$this->output ='Login Failed';	}
				else{return  $ssh;}
	}
   
    public function Moniter()
    {
		$command = 'df --output=source,used,avail -h ';
		$output = ($this->SSH())->exec($command);
		var_dump($output);
		die;
		
    }

    
}
