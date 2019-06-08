<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','crypto_id','seed','ip',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	public function Usernode()
    {
        return $this->hasMany('App\usermasternode');
    }
	 public function setPasswordAttribute($password)
    {   
        //$this->attributes['password'] = bcrypt($password);
		$this->attributes['password']= $password;

    }
	public function masternode()
    {
        return $this->hasMany('App\usermasternode');
    }
	public function Usermeta()
    {
        return $this->hasOne('App\Usermeta');
    }
}
