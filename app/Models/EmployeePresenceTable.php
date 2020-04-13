<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeePresenceTable extends Model
{
	protected $table = 'employee_presence_table';
	protected $dates = [
    	'presence_date',
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
