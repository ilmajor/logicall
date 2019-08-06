<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
Use App\Task;
Use App\User;
Use App\OktellSetting;
Use DB;

class AlgorithmSettingsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('AuthAdmin');
	}

	public static function index()
	{
		//$Tasks = Task::orderBy('project')->orderBy('name')->get();
		$Tasks = Task::with('project')
			->get();
		$Tasks = $Tasks->sortBy('project.name')->sortBy('name');
		return view('admin.task.index',compact('Tasks'));
	}
	public static function show($id)
	{
		$Task = Task::find($id);
		
		return view('admin.task.show',compact('Task'));
	}
	public static function update($id)
	{
		#dd(request()->input('is_taskid'));
	    $Task = Task::find($id);
	    $Task->update(request()->except(['_method','_token']));
	    
	    $Task->is_taskid = empty(request()->input('is_taskid')) ? 0 : 1;
	    $Task->save();
	    return redirect()->back();
	}
	public function create()
	{
 		$OktellTasks = DB::table('oktell_settings.dbo.A_TaskManager_Tasks')
 			->whereNotIn('id',Task::select('task_id')->get())
 			->orderBy('Name')
 			->get();
		return view('admin.task.create',compact('OktellTasks'));
	}
	public function store(){
		$this->validate(request(),[
			'task_id' => 'required',
			'task_table' => 'required',
			'task_abonent' => 'required',
			'task_phone' => 'required',
			'min_client_time_calls' => 'required',
			'max_client_time_calls' => 'required',

	        'waitcall_min' => 'required',
	        'waitcall_max' => 'required',
	        'max_queue' => 'required',
	        'startqueue' => 'required',
	        'startcount' => 'required',
	        'count_calls' => 'required',
	        'CallMaxCount' => 'required',
	        'StartHour' => 'required',
		]);
		
 		$OktellTasks = DB::table('oktell_settings.dbo.A_TaskManager_Tasks')
 			->leftJoin('oktell_settings.dbo.A_TaskManager_Projects','A_TaskManager_Projects.Id','=','A_TaskManager_Tasks.IdProject')
 			->where('A_TaskManager_Tasks.Id','=', request('task_id'))
 			->select('A_TaskManager_Tasks.*','A_TaskManager_Projects.Name as A_TaskManager_Projects_Name')
 			->first();
		
		Task::create([
			'task_id' => request('task_id'),
			'task_table' => request('task_table'),
			'task_abonent' => request('task_abonent'),
			'task_phone' => request('task_phone'),
			'project' => $OktellTasks->A_TaskManager_Projects_Name,
			'project_id' => $OktellTasks->IdProject,
			'user_id' => Auth::id(),
			'is_taskid' => !empty(request('is_taskid')) ? "true" : "false",
			'name' => $OktellTasks->Name,
			'min_client_time_calls' => request('min_client_time_calls'),
			'max_client_time_calls' => request('max_client_time_calls'),
		]);

		OktellSetting::create([
			'idtask' => request('task_id'),
	        'waitcall_min' => request('waitcall_min'),
	        'waitcall_max' => request('waitcall_max'),
	        'max_queue' => request('max_queue'),
	        'startqueue' => request('startqueue'),
	        'startcount' => request('startcount'),
	        'count_calls' => request('count_calls'),
	        'CallMaxCount' => request('CallMaxCount'),
	        'StartHour' => request('StartHour'),
		]);

		return redirect()->back();
	}

}
