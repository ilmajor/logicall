<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CompletionCode;
use App\Repositories\CompletionCodes;
use App\Models\Task;
use App\Models\User;

class CompletionCodesController extends Controller
{
	public function tasks()  
	{
		$tasks = Task::availableOutbound(Auth::id());
		$tasks = $tasks->sortBy('project.name')->sortBy('name');
		return view('CompletionCodes.tasks',compact([
			'tasks'
		]));
	}

	public function index(Task $task)
	{
		$this->authorize('access', $task->project);

		if ($task->is_outbound != true) {
			return redirect()->route('tasksCompletionCodes');
		}
		
		$CompletionCodes = $task->CompletionCodes;

		return view('CompletionCodes.index',compact([
			'task',
			'CompletionCodes'
		]));
	}

	public function show(Task $task, $CompletionCode)
	{
		$this->authorize('access', $task->project);
		if ($task->is_outbound != true) {
			return redirect()->route('tasksCompletionCodes');
		}
		
		$CompletionCode = CompletionCodes::getCompletionCode($task->uuid,$CompletionCode);
		$callAlgorithms = DB::table('oktell.dbo.algorithm_call_status')->get();
		
		return view('CompletionCodes.show',compact([
			'CompletionCode'
			,'task'
			,'callAlgorithms'
		]));
	}

	public function update(Task $task, $CompletionCode)
	{

		$this->validate(request(),[
			'Name' => 'required',
			'code_name' => 'required',
			'code_descript' => 'required',
			'code_name_short' => 'required'
		]);

		$CompletionCodeModel = CompletionCode::where('TaskId', $task->uuid)
			->where('Result',$CompletionCode);
		//$CompletionCodeModel = CompletionCodes::getCompletionCode($task->uuid,$CompletionCode);
		
		$CompletionCodeModel->update([
			'Name' => request('Name'),
			'code_name' => request('code_name'),
			'code_descript' => request('code_descript'),
			'TRUE' => request()->has('TRUE') ? true : NULL,
			'DIAL' => request()->has('DIAL') ? true : NULL,
			'PRESENTATION' => request()->has('PRESENTATION') ? true : NULL,
			'CONSENT' => request()->has('CONSENT') ? true : NULL,
			'CONSENT_OP' => request()->has('CONSENT_OP') ? true : NULL,
			'NotShow' => request()->has('NotShow') ? true : NULL,
			'IsNotFinal' => request()->has('IsNotFinal') ? true : NULL,
			'code_name_short' => request('code_name_short'),
			'call_algorithm' => request('call_algorithm')
		]);
		//dd($CompletionCodeModel);
		return redirect()->route('CompletionCodes', [$task->id]);

	}


	public function create(Task $task)
	{	
		$callAlgorithms = DB::table('oktell.dbo.algorithm_call_status')->get();
		return view('CompletionCodes.create',compact([
			'task',
			'callAlgorithms'
		]));
	}

	public function store(Task $task)
	{
		$this->validate(request(),[
			'Name' => 'required',
			'code_name' => 'required',
			'code_descript' => 'required',
			'code_name_short' => 'required'
		]);
		$Result = CompletionCode::where('TaskId',$task->uuid)->max('Result')+1;
		$data = CompletionCode::create([
			'Result' => $Result,
			'Name' => request('Name'),
			'code_name' => request('code_name'),
			'code_descript' => request('code_descript'),
			'TRUE' => request()->has('TRUE') ? true : NULL,
			'DIAL' => request()->has('DIAL') ? true : NULL,
			'PRESENTATION' => request()->has('PRESENTATION') ? true : NULL,
			'CONSENT' => request()->has('CONSENT') ? true : NULL,
			'CONSENT_OP' => request()->has('CONSENT_OP') ? true : NULL,
			'NotShow' => request()->has('NotShow') ? true : NULL,
			'IsNotFinal' => request()->has('IsNotFinal') ? true : NULL,
			'TaskId' => $task->uuid,
			'code_name_short' => request('code_name_short'),
			'call_algorithm' => request('call_algorithm')

		]);
		
		return redirect()->route('CompletionCodes', [$task->id]);
	}
}
