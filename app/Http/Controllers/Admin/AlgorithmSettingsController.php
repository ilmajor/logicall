<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
Use App\Models\Task;
use App\Models\Project;
Use App\Models\User;
Use App\Models\OktellSetting;
Use DB;

class AlgorithmSettingsController extends Controller
{
	public function __construct()
	{ 
		##$this->middleware('auth');
		#$this->middleware('AuthAdmin');
	}

	public static function index()
	{
		//$Tasks = Task::orderBy('project')->orderBy('name')->get();
		$Tasks = Task::with('project')->get();
		$Tasks = $Tasks->sortBy('project.name')->sortBy('name');
		return view('admin.task.index',compact('Tasks'));
	}

	public static function show(Task $Task)
	{
		#$Task = Task::find($id);

		$OktellSetting = OktellSetting::where('idtask',$Task->uuid)->first();
		
		return view('admin.task.show',compact(['OktellSetting','Task']));
	}

	public static function update(Task $Task)
	{
		if ($Task->is_outbound != true) {
			return redirect()->route('admnTasks');
		}
	    $OktellSetting = OktellSetting::where('idtask',$Task->uuid)->first();
	    $Task->update(request()->except(['_method','_token','max_client_time_calls','min_client_time_calls']));
	    
	    $Task->is_taskid = empty(request()->input('is_taskid')) ? 0 : 1;
	    $Task->save();
	    
	    $OktellSetting->MaxClientTimeCalls = request('max_client_time_calls');
	    $OktellSetting->MinClientTimeCalls = request('min_client_time_calls');
	    $OktellSetting->save();
	    return redirect()->back();
	}

	public function create()
	{
 		$OktellTasks = DB::table('oktell_settings.dbo.A_TaskManager_Tasks')
 			->whereNotIn('id',Task::select('uuid')->get())
 			->orderBy('Name')
 			->get();
		return view('admin.task.create',compact('OktellTasks'));
	}
	public function store(){
		$this->validate(request(),[
			'task_id' => 'required',
			'task_table' => 'required'
/*			'task_abonent' => 'required',
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
	        'StartHour' => 'required',*/
		]);
		
 		$OktellTasks = DB::table('oktell_settings.dbo.A_TaskManager_Tasks')
 			->leftJoin('oktell_settings.dbo.A_TaskManager_Projects','A_TaskManager_Projects.Id','=','A_TaskManager_Tasks.IdProject')
 			->where('A_TaskManager_Tasks.Id','=', request('task_id'))
 			->select('A_TaskManager_Tasks.*','A_TaskManager_Projects.Name as A_TaskManager_Projects_Name')
 			->first();
		
		$project = Project::where('uuid',$OktellTasks->IdProject)->first();

		Task::create([
			'uuid' => $OktellTasks->Id,
			'task_table' => request('task_table'),
			'task_abonent' => request('task_abonent'),
			'task_phone' => request('task_phone'),
			
			'project_id' => $project->id,
			'user_id' => Auth::id(),
			'is_taskid' => !empty(request('is_taskid')) ? "true" : "false",
			'is_new_algorithm' => !empty(request('is_new_algorithm')) ? "true" : "false",
			'name' => $OktellTasks->Name,
			'is_outbound' =>  !empty($OktellTasks->IsOutputTask) ? "true" : "false",
			'client_id' => !empty(request('client_id')) ? request('client_id') : null,
			'status_call_table' => !empty(request('status_call_table')) ? request('status_call_table') : null,
			'max_client_time_calls' => request('max_client_time_calls'),
			'min_client_time_calls' => request('min_client_time_calls')

		]);

 		if($OktellTasks->IsOutputTask == true && request()->is_new_algorithm){
 			//dd(request()->except(['_method','_token']));
			
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
				'MinClientTimeCalls' => request('min_client_time_calls'),
				'MaxClientTimeCalls' => request('max_client_time_calls')
			]);
 		}
 		
		return redirect()->back();
	}

	public function dublicateIndex(Task $Task)
	{
		$OktellTasks = Task::select('name','uuid')
			->orderBy('name')
			->get();

		return view('admin.task.showDublicate',compact(['OktellTasks','Task']));
	}
	public function dublicateSend(Task $Task){
		$this->validate(request(),[
			'tables' => 'required',
			'task_id' => 'required'
		]);
		$client = new \GuzzleHttp\Client();
		$url = 'http://10.2.19.146:5001/task_preparation';

		$options = [
			'form_params' => [
				'new_id' => $Task->uuid,
				'old_id' => request('task_id'),
				'tables' => request('tables')
			]
		]; 
		
		$response = $client->post($url, $options);
		$answer = $response->getBody()->read(1024);
		
		return back()->withErrors($answer);
		
		
	}
}
