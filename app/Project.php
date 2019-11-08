<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'director'
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
