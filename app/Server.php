<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    
    protected $table='server';
	 public function IPS()
    {
        return $this->hasmany('App\IP');
    }
	
}
