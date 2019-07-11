<?php

namespace App;


class Section extends Model
{
	public function role()
	{
		return $this->belongsTo(Role::class);
	}

	public function user()
	{
	 	return $this->belongsTo(User::class);
	}
}
