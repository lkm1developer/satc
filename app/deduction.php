<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class deduction extends Model
{
    public function user()
    {
        return $this->belongsto('App\user');
    }
	
	public function TransactionsUser()
    {
        return $this->belongsto('App\user');
    }
	public function coin()
	{
		return $this->belongsTo('App\allmasternode', 'coin_id');
	}
	public function masternode()
	{
		return $this->belongsTo('App\usermasternode', 'mid');
	}
	
}
