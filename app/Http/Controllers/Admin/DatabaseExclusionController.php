<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
#use Illuminate\Support\Facades\Schema;
#use Illuminate\Support\Facades\Auth;
Use App\Task;
Use DB;
Use App\DatabaseExclusion;
Use App\Section;
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
		$this->middleware('auth');
		$this->middleware('AuthAdmin');
	}

	public static function index()
	{
		//$Tasks = Task::orderBy('project')->orderBy('name')->get();
		$Tasks = Task::whereNotNull('task_table')
			->get();
		$Tasks = $Tasks->sortBy('project.name')->sortBy('name');
		
		return view('admin.DatabaseExclusion.index',compact('Tasks'));
	}

	public static function show($id)
	{

		$task = Task::find($id);
		$DatabaseExclusions = DatabaseExclusion::where('task_id',$id)->get();

		$columns = DB::connection('oktell')
			->getSchemaBuilder()
			->getColumnListing(str_replace('oktell.dbo.', '', $task->task_table));
		
		return view('admin.DatabaseExclusion.show',compact(
			'task'
			,'DatabaseExclusions'
			,'columns'
		));
	}

	public function update($id)
	{
		
		$this->validate(request(),[
			'column' => 'required'
		]);

		$columns = request()->input('column');

		$DatabaseExclusions = DatabaseExclusion::where('task_id',$id)->get();

		DatabaseExclusion::where('task_id',$id)
			->whereNotIn('exclusion_column',request()->input('column'))
			->delete();

		$Task = Task::find($id);
		
		foreach($columns as $column) {
			if((!empty($column)) && !in_array($column, $DatabaseExclusions->pluck('exclusion_column')->toArray()))
			{
				$Task->databaseExclusion()->create([
					'task_id' => $id,
					'exclusion_column' => $column

				]);
			}
		}
		return redirect()->back();
	}
}
