<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class allmasternode extends Model
{
    public function masternode()
    {
        return $this->hasOne('App\usermasternode','masternode_id');
    }
	public function MNS()
    {
        return $this->hasmany('App\usermasternode','masternode_id')->where('step',5);
    }
}
