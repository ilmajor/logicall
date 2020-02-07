<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
#use Illuminate\Support\Facades\Schema;
#use Illuminate\Support\Facades\Auth;
Use App\Models\Task;
Use DB;
Use App\Models\DatabaseExclusion;
Use App\Models\Section;
use Illuminate\Support\Arr;
/*
Use App\Project;
Use App\User;
Use App\OktellSetting; 

*/
class DatabaseExclusionController extends Controller
{
	public function __construct()
	{
		#$this->middleware('auth');
		#$this->middleware('AuthAdmin');
	}

	public static function index()
	{
		//$Tasks = Task::orderBy('project')->orderBy('name')->get();
		$Tasks = Task::whereNotNull('task_table')
			->whereNotNull('is_outbound')
			->get();
		$Tasks = $Tasks->sortBy('project.name')->sortBy('name');
		
		return view('admin.DatabaseExclusion.index',compact('Tasks'));
	}

	public static function show(Task $task)
	{

		if ($task->is_outbound != true) {
			return redirect()->route('admnDatabaseExclusions');
		}

		$DatabaseExclusions = DatabaseExclusion::where('task_id',$task->id)->get();

		$columns = DB::connection('oktell')
			->getSchemaBuilder()
			->getColumnListing(str_replace('oktell.dbo.', '', $task->task_table));
		
		return view('admin.DatabaseExclusion.show',compact(
			'task'
			,'DatabaseExclusions'
			,'columns'
		));
	}

	public function update(Task $task)
	{
		if ($task->is_outbound != true) {
			return redirect()->route('admnDatabaseExclusions');
		}
		
		$this->validate(request(),[
			'column' => 'required'
		]);

		$columns = request()->input('column');

		$DatabaseExclusions = DatabaseExclusion::where('task_id',$task->id)->get();

		DatabaseExclusion::where('task_id',$task->id)
			->whereNotIn('exclusion_column',request()->input('column'))
			->delete();
		
		foreach($columns as $column) {
			if((!empty($column)) && !in_array($column, $DatabaseExclusions->pluck('exclusion_column')->toArray()))
			{
				$Task->databaseExclusion()->create([
					'task_id' => $task->id,
					'exclusion_column' => $column

				]);
			}
		}
		return redirect()->back();
	}
}
