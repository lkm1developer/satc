<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class usermasternode extends Model
{
	 use SoftDeletes;
	 protected $dates = ['deleted_at'];
   public function masternode()
    {
        return $this->belongsTo('App\allmasternode','masternode_id');
    } 
	public function IPS()
    {
        return $this->belongsTo('App\IP','ips_id');
    }
}
