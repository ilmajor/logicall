<?php

namespace App\Models;

class EmployeePresenceTable extends Model
{
	protected $table = 'employee_presence_table';
	protected $dates = [
		'presence_date'
	];

    protected $fillable = [
		'work_time',
		'condition',
		'comment'
    ];

	public function user()
	{
		return $this->hasOne(User::class, 'id' ,'user_id');
	}

	public function available($id)
	{
		return User::with('project')
			->where(function ($query) use($id) {
				$query->whereIn('project_id',User::find($id)->projects->pluck('id'))
					->orWhereNull('project_id');
			})
			->get();
	}

	public function status()
	{
		return $this->hasOne(EmployeePresenceStatus::class, 'id' ,'condition');
	}
}
