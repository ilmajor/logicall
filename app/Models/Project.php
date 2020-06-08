<?php

namespace App\Models;

class Project extends Model
{
    protected $fillable = [
        'director',
        'is_enabled'
    ];
	public function task()
	{
	  	return $this->hasMany(Task::class);
	}
	public function sections()
	{
	  	return $this->belongsToMany(Section::class)->withTimestamps();
	}	
	public function users()
	{
	  	return $this->belongsToMany(User::class)->withTimestamps();
	}


}
