<?php

namespace App\Repositories;
use App\Models\CompletionCode;

class CompletionCodes
{
	public function getCompletionCode($uuid, $CompletionCode)
	{
		return CompletionCode::where('TaskId', $uuid)
			->where('Result',$CompletionCode)
			->first();
	}
}
