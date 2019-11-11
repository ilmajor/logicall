<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'director',
        'name',
        'address',
        'uuid'
    ];

	public function user(){
		return $this->hasOne(User::class,'id','director');
	}

	public function director(){
		return $this->hasOne(Profile::class,'user_id','director');
	}

	public function profile(){
		return $this->hasOne(Profile::class,'city','id');
	}
}