<?php

namespace App\Models;

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

	public static function UsersMaxWeight($id)
	{
		return static::where('weight','>',User::find($id)->roles->max('weight'))
			->with('users')
			->first();
	}
}