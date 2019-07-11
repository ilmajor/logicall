<?php

namespace App;

class Role extends Model

{
	public function users()
	{
	  return $this->belongsToMany(User::class)->withTimestamps();
	}

	public function sections()
	{
		return $this->hasMany(Section::class);
	}
}