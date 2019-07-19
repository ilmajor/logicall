<?php

namespace App;


class Section extends Model
{

	public function role()
	{
		return $this->belongsTo(Role::class);
	}


	public function projects()
	{
		return $this->belongsToMany(Project::class)->withTimestamps();
	}

/*	public function user()
	{
	 	return $this->belongsTo(User::class);
	}
*/
/*    public function tasks()
    {
      return $this->belongsToMany(Task::class)->withTimestamps();
    }*/
}
