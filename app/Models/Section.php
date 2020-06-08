<?php

namespace App\Models;

class Section extends Model
{

	public function role()
	{
		return $this->belongsToMany(Role::class)->withTimestamps();
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

    public static function available($id)
    {
		return static::selectRaw('url,title,description,max(role_section.role_id) as role_id')
			->leftJoin('role_section','role_section.section_id','=','Sections.id')
			->leftJoin('project_section','project_section.section_id','=','Sections.id')
			->whereIn('role_section.role_id', User::find($id)->roles->pluck('id'))
			->where(function ($query) use($id)  {		
				$query->whereIn('project_section.project_id',User::find($id)->projects->pluck('id'))
					->orWhereNull('project_section.project_id')
					->orWhere('project_section.project_id','0');
			})
			->groupBy('sections.title','sections.id','sections.description','sections.url')	
			->orderBy('title')
			->get();
    }
}
