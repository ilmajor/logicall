<?php

namespace App\Models;



class Profile extends Model
{

    protected $casts = [
        'Project' => 'array',
    ];

/*
	public function getKeyName(){
	    return "user_id";
	}
	*/

	protected $primaryKey = 'user_id';

	public function users()
	{
		return $this->hasOne(User::class, 'id' ,'user_id');
	}

	public function city(){
		return $this->hasOne(City::class,'id','City');
	}

}
