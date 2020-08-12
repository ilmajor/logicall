<?php

namespace App\Models;

class City extends Model
{
    protected $fillable = [
        'director',
        'name',
        'address',
        'uuid',
        'CCTV',
        'security_phone_numbers'
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
