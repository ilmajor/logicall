<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompletionCode extends Model
{
	protected $connection= 'oktell';
	protected $table = 'Results_test';

	protected $primaryKey = 'Result';
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
		'IsNotFinal'
	];

	public static function getCompletionCode($uuid, $CompletionCode)
	{
		return static::where('TaskId', $uuid)
			->where('Result',$CompletionCode)
			->first();

	}
}