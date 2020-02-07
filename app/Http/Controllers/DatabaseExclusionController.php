<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

use DB;
use App\Models\Task;
use App\Models\User;
use App\Models\OktellSetting;
use Carbon\Carbon;
Use App\Models\DatabaseExclusion;

class DatabaseExclusionController extends Controller
{
    public function __construct()
    {
    	#
    }

	public static function index()
	{
		$tasks = Task::availableOutbound(Auth::id());
		$tasks = $tasks->whereIn('id',DatabaseExclusion::pluck('task_id'));
		$tasks = $tasks->sortBy('project.name')->sortBy('name');
		return view('DatabaseExclusion.index',compact('tasks'));
	}

	public function show(Task $task)
	{

		if ($task->is_outbound != true) {
			return redirect()->route('DatabaseExclusions');
		}
		$this->authorize('access', $task->project);
		$DatabaseExclusions = DatabaseExclusion::where('task_id',$task->id)->get();
		foreach ($DatabaseExclusions as $DatabaseExclusion) {
			
			$Exclusion = DB::table($task->task_table)
				->selectRaw(
					$DatabaseExclusion->exclusion_column.' as data'
					.', count('.$DatabaseExclusion->exclusion_column.') as count'
				)
				->whereNull('statusflag')
				->groupBy($DatabaseExclusion->exclusion_column)
				->get();

			$Inclusion = DB::table($task->task_table)
				->selectRaw(
					$DatabaseExclusion->exclusion_column.' as data'
					.', count('.$DatabaseExclusion->exclusion_column.') as count'
				)
				->where('statusflag', 'C')
				->groupBy($DatabaseExclusion->exclusion_column)
				->get();


			if(!empty($Exclusion->toArray())){
				foreach($Exclusion as $value){
					$columnsExclusion[$DatabaseExclusion->exclusion_column][$value->data] = $value->count;
				}
			}
			else{
				$columnsExclusion[$DatabaseExclusion->exclusion_column][Null] = Null;
			}

			if(!empty($Inclusion->toArray())){
				foreach($Inclusion as $value){
					$columnsInclusion[$DatabaseExclusion->exclusion_column][$value->data] = $value->count;
				}
			}
			else{
				$columnsInclusion[$DatabaseExclusion->exclusion_column][Null] = Null;
			}
		}

		return view('DatabaseExclusion.show',compact(
			'task'
			,'DatabaseExclusions'
			,'columnsInclusion'
			,'columnsExclusion'
		));
	}

	public function exclusion(Task $task)
	{
		if ($task->is_outbound != true) {
			return redirect()->route('DatabaseExclusions');
		}
		$this->authorize('access', $task->project);

		$request = request()->except(['_method','_token']);
		$query = DB::connection('oktell')
			->table($task->task_table);
			if(is_array($request)) {
				foreach ($request as $key => $value) {
					$query->where($key, $value);
				}
		}
		$a = $query->update(['statusflag'=>'C']);	
		return redirect()->back();
	}

	public function inclusion(Task $task)
	{
		if ($task->is_outbound != true) {
			return redirect()->route('DatabaseExclusions');
		}
		$this->authorize('access', $task->project);
		$request = request()->except(['_method','_token']);

		$query = DB::connection('oktell')
			->table($task->task_table);

		if(is_array($request)) {
			foreach ($request as $key => $value) {
				$query->where($key, $value);
			}
		}

		$a = $query->update(['statusflag'=>null]);

		return redirect()->back();
	}
}
