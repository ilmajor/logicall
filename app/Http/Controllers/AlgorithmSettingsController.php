<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Task;
use App\User;
use App\OktellSetting;
use Carbon\Carbon;

class AlgorithmSettingsController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('AuthManager');
    }

    public function task()
    {
      $tasks = Task::WhereIn('project', User::find(Auth::id())->profiles->Project)
        ->orderBy('project')
        ->orderBy('name')
			  ->get();
		  return view('algorithmSettings.tasks',compact([
			   'tasks'
      ])
      );
   }

   public function index($id)
   {
      $task = Task::find($id);
      
      $settings = OktellSetting::find($id);
      
      $queue = DB::connection('sqlsrv_srn')
        ->table("oktell.dbo.udf_go_from_queue_callout_from_dialing ('$task->task_id')")
        ->first();

      $baseData = DB::table($task->task_abonent)
        ->leftJoin($task->task_phone, function ($join) use($task) {
          if($task->is_taskid == 1){
            $join->on($task->task_abonent.'.id_abonent','=', $task->task_phone.'.id_abonent')
              ->on($task->task_abonent.'.TaskId','=',$task->task_phone.'.TaskId');
          }
          else {
            $join->on($task->task_abonent.'.id_abonent','=', $task->task_phone.'.id_abonent');
          }

            
        })
        ->where($task->task_abonent.'.in_work', '=', 'NO')
        ->whereNotIn($task->task_abonent.'.status',[50])
        ->where($task->task_phone.'.count', '<', $settings->count_calls)
        ->where($task->task_phone.'.next_call_time', '<', Carbon::now())
        ->whereNull($task->task_phone.'.bad_num')
        ->whereIn($task->task_abonent.'.id_abonent',function($query) use($task){
          $query->select('id')->from($task->task_table);
        })
        ->where(function($query){
          $query->where('date_last_changes','<',Carbon::now())
            ->orWhereNull('date_last_changes');
        })
        ->where(function($query) use($task){
          $query->whereNull($task->task_abonent.'.TIMEDIFF')
            ->orWhereBetween(DB::raw('TIMEDIFF + datepart(hh,getdate())'),[9,20]);
        })
        ->where(function($query) use($task){
          if($task->is_taskid == 1){
            $query->where($task->task_abonent.'.TaskId','=',$task->task_id);
          }
            
        })
        ->selectRaw('count(*) as selection,( select count(*) as cc  from '.$task->task_table.') as base')
        ->first();
      return view('algorithmSettings.index',compact([
         'task',
         'baseData',
         'queue',
         'settings'
         ])
      );
   }
   public function update($id)
   {
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

      $settings = OktellSetting::find($id);

      $settings->update(request()->except(['_method','_token']));
      
      $settings->save();
      
      return redirect()->back();
   }
}
