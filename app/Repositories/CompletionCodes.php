<?php

namespace App\Repositories;
use App\Models\CompletionCode;

class CompletionCodes
{
	public static function getCompletionCode($uuid, $CompletionCode)
	{
		return CompletionCode::where('TaskId', $uuid)
			->where('Result',$CompletionCode)
			->first();
	}

	public static function getTaskCompletionCode($uuid)
	{
		return CompletionCode::where('TaskId', $uuid)
			->whereNull('NotShow')
			->orderBy('Name')
			->get();
	}
}
