<?php

namespace App\Http\Controllers\Admin\project\sberbankLE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\project\sberbankLE\Tecos;
Use App\Task;

class TecosController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('AuthAdmin');
	}
    public static function index()
    {
    	$tecos = Tecos::with('task')
    		->get();
    	
    	return view('admin.tecos.index',compact([
    		'tecos'
    	])
    	);
    }

	public static function show($id)
	{
		$tecos = Tecos::find($id)->with('task')->first();
		return view('admin.tecos.show',compact(
			'tecos'
		));
	}

	public static function update($id)
	{
	    $tecos = Tecos::find($id);
	    $tecos->update(request()->except(['_method','_token']));
	    $tecos->save();
	    return redirect()->back();
	}

	public function create()
	{	
		$tasks = Task::whereNotIn('uuid',Tecos::get()->pluck('uuid'))
			->orderBy('name')
			->where('project_id',27)
			->get();
		
		return view('admin.tecos.create',compact([
			'tasks'
		]));
	}

	public function store(){
		$this->validate(request(),[
		  'task_table' => 'required',
		  'task' => 'required',
		]);

		$task = Task::find(request('task'));
		$daily = $task->task_table;
		$uuid = $task->uuid;
	
		Tecos::create([
		  'task_table' => request('task_table'),
		  'uuid' => $uuid,
		  'task_table_daily' => $daily,
		  'task_table_start_log' => 'oktell.dbo.Tm_legal_entity_base_start_log',
		  'task_table_stop_log' => 'oktell.dbo.Tm_legal_entity_base_stop_log',
		]);

		return redirect()->back();
	}

	public function destroy($id){
		Tecos::find($id)->delete();
		return redirect()->back();
	}
}
