<?php

namespace App;

class OktellSetting extends Model
{
	protected $connection= 'oktell';
    protected $table = 'oktell.dbo.sb_task_settings';
	public $timestamps = false;

    protected $fillable = [
        'waitcall_min',
        'waitcall_max',
        'max_queue',
        'startqueue',
        'startcount',
        'count_calls',
        'CallMaxCount',
        'StartHour',
        'idtask'
    ];
/*	public function getKeyName(){
	    return 'idtask';
	}*/
    protected $primaryKey = 'id';

	public function show()
	{
		return $this->hasOne(Task::class,'uuid','idtask');
	}
}
