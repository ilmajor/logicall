<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CompletionCode;
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
		$CompletionCode = CompletionCode::getCompletionCode($task->uuid,$CompletionCode);
		return view('CompletionCodes.show',compact([
			'CompletionCode'
			,'task'
		]));
	}

	public function update(Task $task, $CompletionCode)
	{
		$this->validate(request(),[
			'Name' => 'required',
			'code_name' => 'required',
			'code_descript' => 'required'
		]);
		$CompletionCode = CompletionCode::getCompletionCode($task->uuid,$CompletionCode);
		
		$CompletionCode->update([
			'Name' => request('Name'),
			'code_name' => request('code_name'),
			'code_descript' => request('code_descript'),
			'TRUE' => request()->has('TRUE'),
			'DIAL' => request()->has('DIAL'),
			'PRESENTATION' => request()->has('PRESENTATION'),
			'CONSENT' => request()->has('CONSENT'),
			'CONSENT_OP' => request()->has('CONSENT_OP'),
			'NotShow' => request()->has('NotShow'),
			'IsNotFinal' => request()->has('IsNotFinal')
		]);
		
		return redirect()->route('CompletionCodes', ['id' => $task->id]);

	}


	public function create(Task $task)
	{
		return view('CompletionCodes.create',compact([
			'task'
		]));
	}

	public function store(Task $task)
	{
		$this->validate(request(),[
			'Name' => 'required',
			'code_name' => 'required',
			'code_descript' => 'required'
		]);
		$Result = CompletionCode::where('TaskId',$task->uuid)->max('Result')+1;
		$data = CompletionCode::create([
			'Result' => $Result,
			'Name' => request('Name'),
			'code_name' => request('code_name'),
			'code_descript' => request('code_descript'),
			'TRUE' => request()->has('TRUE'),
			'DIAL' => request()->has('DIAL'),
			'PRESENTATION' => request()->has('PRESENTATION'),
			'CONSENT' => request()->has('CONSENT'),
			'CONSENT_OP' => request()->has('CONSENT_OP'),
			'NotShow' => request()->has('NotShow'),
			'IsNotFinal' => request()->has('IsNotFinal'),
			'TaskId' => $task->uuid

		]);
		
		return redirect()->route('CompletionCodes', ['id' => $task->id]);
	}
}