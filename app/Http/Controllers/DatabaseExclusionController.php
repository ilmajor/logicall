<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Task;
use App\User;
use App\OktellSetting;
use Carbon\Carbon;
Use App\DatabaseExclusion;

class DatabaseExclusionController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('AuthManager');
    }

	public static function index()
	{
		$tasks = Task::with('project')
			->where(function ($query) {
				$query->whereIn('project_id',User::find(Auth::id())->projects->pluck('id'))
					->orWhereNull('project_id');
			})
			->whereIn('id',DatabaseExclusion::pluck('task_id'))
			->get();

		$tasks = $tasks->sortBy('project.name')->sortBy('name');
		
		return view('DatabaseExclusion.index',compact('tasks'));
	}

	public static function show($id)
	{

		$task = Task::find($id);

		$DatabaseExclusions = DatabaseExclusion::where('task_id',$id)->get();
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
			#$columns[$DatabaseExclusion->exclusion_column]['data'] = $data->pluck('data');
			#$columns[$DatabaseExclusion->exclusion_column]['count'] = $data->pluck('count');
		}

		return view('DatabaseExclusion.show',compact(
			'task'
			,'DatabaseExclusions'
			,'columnsInclusion'
			,'columnsExclusion'
		));
	}

	public function exclusion($id)
	{

		/*      
			$this->validate(request(),[
			'waitcall_min' => 'required',
			'waitcall_max' => 'required',
			'max_queue' => 'required',
			'startqueue' => 'required',
			'startcount' => 'required',
			'count_calls' => 'required',
			'CallMaxCount' => 'required',
			'StartHour' => 'required' 
			]);
		*/
		$task = Task::find($id);

		//$DatabaseExclusions = DatabaseExclusion::where('task_id',$id)->get();
		$request = request()->except(['_method','_token']);

		$query = DB::connection('oktell')
			->table($task->task_table);
			if(is_array($request)) {
				foreach ($request as $key => $value) {
					$query->where($key, $value);
				}
		}

		$a = $query->update(['statusflag'=>'C']);

		/*     
		$task->update(request()->except(['_method','_token']));
		$task->save();
		*/
		
		return redirect()->back();
	}

	public function inclusion($id)
	{

		$task = Task::find($id);

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
