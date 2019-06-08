<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Serverfor extends Model
{
    
   protected $table='Serverfor';
	 public function IPS()
    {
        //return $this->hasmany('App\IP');
    }
	
}
