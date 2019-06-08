<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IP extends Model
{
    public function Server()
    {
        return $this->belongsTo('Server');
		
    } 
	public function MNS()
    {
        return $this->hasone('App\usermasternode','ips_id');
    }
}
