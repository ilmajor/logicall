<?php

namespace App\Models;

class CompletionCode extends Model
{
	protected $connection= 'oktell';
	protected $table = 'Results_test';

	//protected $primaryKey = 'ID';
    protected $primaryKey = 'Result';
    public $incrementing = false;
	protected $fillable = [
		'Result',
		'Name',
		'code_name',
		'code_descript',
		'TRUE',
		'DIAL',
		'PRESENTATION',
		'CONSENT',
		'CONSENT_OP',
		'TaskId',
		'NotShow',
		'IsNotFinal',
		'code_name_short',
		'call_algorithm'
	];

/*	public static function getCompletionCode($uuid, $CompletionCode)
	{
		return static::where('TaskId', $uuid)
			->where('Result',$CompletionCode)
			->first();
	}*/
}