<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Task;
use App\Models\User;
use App\Models\OktellSetting;
use Carbon\Carbon;

class AlgorithmSettingsController extends Controller
{
    public function __construct()
    {
      #$this->middleware('auth');
      #$this->middleware('AuthManager');
    }

    public function index()
    {

        $tasks = Task::availableOutbound(Auth::id());
        $tasks = $tasks->sortBy('project.name')->sortBy('name');
        return view('algorithmSettings.tasks',compact([
          'tasks'
        ]));
    }

    public function show(Task $task)
    {

      $this->authorize('access', $task->project);

      if ($task->is_outbound != true) {
        return redirect()->route('algorithmSettings');
      }

      $settings = OktellSetting::where('idtask',$task->uuid)->first();

      $queue = DB::connection('sqlsrv_srn')
        ->table("oktell.dbo.udf_go_from_queue_callout_from_dialing ('$task->uuid')")
        ->first();

      $date = Carbon::now();
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
        ->where($task->task_phone.'.next_call_time', '<', $date )
        ->whereNull($task->task_phone.'.bad_num')
        ->whereIn($task->task_abonent.'.id_abonent',function($query) use($task){
          $query->select('id')->from($task->task_table)->whereNull('statusflag');
        })
        ->where(function($query)use($date){
          $query->where('date_last_changes','<',$date )
          ->orWhereNull('date_last_changes');
        })
        ->where(function($query) use($task,$settings){
          $query->whereNull($task->task_abonent.'.TIMEDIFF')
            ->orWhereBetween(
            DB::raw('TIMEDIFF + datepart(hh,getdate())')
            ,[$settings->MinClientTimeCalls,$settings->MaxClientTimeCalls]
          );
        })
        ->where(function($query) use($task){
          if($task->is_taskid == 1){
            $query->where($task->task_abonent.'.TaskId','=',$task->uuid);
          }
        })
        ->selectRaw('count(*) as selection,( select count(*) as cc  from '.$task->task_table.') as base')
        ->first();

      $date = Carbon::tomorrow()->addHour(7);
      $baseDataTomorrow = DB::table($task->task_abonent)
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
        ->where($task->task_phone.'.next_call_time', '<', $date)
        ->whereNull($task->task_phone.'.bad_num')
        ->whereIn($task->task_abonent.'.id_abonent',function($query) use($task){
          $query->select('id')->from($task->task_table)->whereNull('statusflag');
        })
        ->where(function($query)use($date){
          $query->where('date_last_changes','<',$date)
          ->orWhereNull('date_last_changes');
        })
        ->where(function($query) use($task,$settings){
          $query->whereNull($task->task_abonent.'.TIMEDIFF')
            ->orWhereBetween(
            DB::raw('TIMEDIFF + datepart(hh,DATEADD (HOUR,'.$settings->StartHour.',cast(DATEADD(d,1,cast(getdate() as date))as datetime)))')
            ,[$settings->MinClientTimeCalls,$settings->MaxClientTimeCalls]
          );
        })
        ->where(function($query) use($task){
          if($task->is_taskid == 1){
          $query->where($task->task_abonent.'.TaskId','=',$task->uuid);
        }
        })
        ->selectRaw('count(*) as selection')
        ->first();

      return view('algorithmSettings.index',compact([
        'task',
        'baseData',
        'queue',
        'settings',
        'baseDataTomorrow'
      ]));
    }
    
   public function update(Task $task)
   {
      if ($task->is_outbound != true) {
        return redirect()->route('algorithmSettings');
      }
      
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

      $task = $task->settings;

      $task->update(request()->except(['_method','_token']));
      $task->save();
      
      return redirect()->back();
   }
}
