<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\User;
use App\Models\OktellSetting;
use Carbon\Carbon;
use App\Repositories\CompletionCodes;

class ChangeCompletionCodeController extends Controller
{
	private $task_table = 'logicall_dev.dbo.Tasks';

	public function index()
	{
		return view('ChangeCompletionCode.index');
	}

	public function show()
	{ 

		$this->validate(request(),[
			'idchain' => 'required'
		]);

		$idchain = request('idchain');

		$data = DB::table('oktell_cc_temp.dbo.A_Cube_CC_EffortConnections')
			->leftJoin($this->task_table,'Tasks.uuid','=','A_Cube_CC_EffortConnections.IdTask')
			->where('A_Cube_CC_EffortConnections.Idchain',$idchain)
			->where('A_Cube_CC_EffortConnections.idchain','!=','00000000-0000-0000-0000-000000000000')
			->where('CallResult','!=','15');

		$task = $data->first();
		
/*		$this->authorize('access', $task->project);

		if ($task->is_outbound != true) {
			return redirect()->route('searchChangeCompletionCode');
		}*/

		$task->task_table = Str::replaceLast('_daily', '', $task->task_table);
		$task->task_table = Str::replaceLast('_certus', '', $task->task_table);

		$ClientCalls = DB::table('oktell_cc_temp.dbo.A_Cube_CC_EffortConnections')
			->leftJoin($task->status_call_table,'A_Cube_CC_EffortConnections.idchain','=',$task->status_call_table.'.idchain')
			->leftJoin('oktell.dbo.Results', function ($join) use($task) {
				$join->on('Results.Result','=',$task->status_call_table.'.result')
					->on('Results.TaskId','=','A_Cube_CC_EffortConnections.IdTask');
					
			})
			->where('A_Cube_CC_EffortConnections.idinlist',$task->IdInList)
			->where('A_Cube_CC_EffortConnections.idchain','!=','00000000-0000-0000-0000-000000000000')
			->where('CallResult','!=','15')
			->where('A_Cube_CC_EffortConnections.idtask',$task->IdTask)
			->whereNotNull($task->status_call_table.'.result')
			->selectRaw('cast(DateStart as date) as DateStart,cast(TimeStart as time) as TimeStart,Results.Name,A_Cube_CC_EffortConnections.idchain')
			->groupBy('A_Cube_CC_EffortConnections.idchain','DateStart','TimeStart','Results.Name')
			->orderBy('DateStart')
			->orderBy('TimeStart')
			->get();

		$CallData = $data->leftJoin($task->status_call_table,'A_Cube_CC_EffortConnections.idchain','=',$task->status_call_table.'.idchain')
			->leftJoin($task->task_table,$task->task_table.'.id','=','A_Cube_CC_EffortConnections.idinlist');
			if (!empty($task->client_id))
			{
				$CallData = $CallData->selectRaw(
						'A_Cube_CC_EffortConnections.idchain
						,Tasks.name
						,idoperator
						,cast(DateStart as date) as DateStart
						,cast(TimeStart as time) as TimeStart
						,'.$task->task_table .'.'.$task->client_id .' as id_client
						,CallResult
						,CallResultInfo
						,sum(LenTime) as LenTime
						,'.$task->status_call_table.'.Result'
					)
					->groupBy(
						'A_Cube_CC_EffortConnections.idchain'
						,'Tasks.name'
						,'idoperator'
						,'DateStart'
						,'TimeStart'
						,$task->task_table .'.'.$task->client_id
						,'CallResult'
						,'CallResultInfo'
						,$task->status_call_table.'.Result'
					);
			}
			else
			{
				$CallData = $CallData->selectRaw(
						'A_Cube_CC_EffortConnections.idchain
						,Tasks.name
						,idoperator
						,cast(DateStart as date) as DateStart
						,cast(TimeStart as time) as TimeStart
						,null as id_client
						,CallResult
						,CallResultInfo
						,sum(LenTime) as LenTime
						,'.$task->status_call_table.'.Result'
					)
					->groupBy(
						'A_Cube_CC_EffortConnections.idchain'
						,'Tasks.name'
						,'idoperator'
						,'DateStart'
						,'TimeStart'
						
						,'CallResult'
						,'CallResultInfo'
						,$task->status_call_table.'.Result'
					);
			}

		$CallData = $CallData->first();

		$Results = CompletionCodes::getTaskCompletionCode($task->uuid);

		return view('ChangeCompletionCode.show',compact([
			'ClientCalls',
			'task',
			'CallData',
			'Results'
		]));
	}

	public function update()
	{
		$this->validate(request(),[
			'Result' => 'required'
		]);
		
		$idchain = request('idchain');

		$dataCall = DB::table('oktell_cc_temp.dbo.A_Cube_CC_EffortConnections')
			->leftJoin($this->task_table,'Tasks.uuid','=','A_Cube_CC_EffortConnections.IdTask')
			->where('A_Cube_CC_EffortConnections.Idchain',$idchain)
			->first();

		$dataCall->task_table = Str::replaceLast('_daily', '', $dataCall->task_table);
		
		$checkCalls = DB::table('oktell_cc_temp.dbo.A_Cube_CC_EffortConnections')
			->leftJoin($dataCall->status_call_table,'A_Cube_CC_EffortConnections.idchain','=',$dataCall->status_call_table.'.idchain')
			->leftJoin('oktell.dbo.Results', function ($join) use($dataCall) {
				$join->on('Results.Result','=',$dataCall->status_call_table.'.result')
					->on('Results.TaskId','=','A_Cube_CC_EffortConnections.IdTask');
					
			})
			->where('A_Cube_CC_EffortConnections.idinlist',$dataCall->IdInList)
			->where('A_Cube_CC_EffortConnections.idchain','!=','00000000-0000-0000-0000-000000000000')
			->where('CallResult','!=','15')
			->whereNotNull($dataCall->status_call_table.'.result')
			->where('A_Cube_CC_EffortConnections.idchain','!=',$idchain)
			->whereNull('Results.IsNotFinal')
			->get();

		$task_abonent_data = DB::connection('oktell')
			->table($dataCall->task_abonent);
		$task_phone_data = DB::connection('oktell')
			->table($dataCall->task_phone);

		if($dataCall->is_taskid == 1)
		{
			$task_abonent_data = $task_abonent_data->where('TaskId',$dataCall->IdTask)
				->where('id_abonent',$dataCall->IdInList);
				//->first();

			$task_phone_data = $task_phone_data->where('TaskId',$dataCall->IdTask)
				->where('id_abonent',$dataCall->IdInList)
				->whereNull('bad_num');
				//->first();
		}
		else
		{
			$task_abonent_data->where('id_abonent',$dataCall->IdInList);
				//->first();

			$task_phone_data->where('id_abonent',$dataCall->IdInList)
				->whereNull('bad_num');
				//->first();
		}
		$task_phone = $task_phone_data->first();
		$task_abonent = $task_abonent_data->first();
		
		if($checkCalls->isEmpty())
		{
			$data = DB::table($dataCall->status_call_table)
				->where('IdChain',$idchain)
				->first();
			$Results = CompletionCodes::getCompletionCode($data->TaskId,request('Result'));
			
			$backUp = DB::connection('oktell')
				->table('oktell.dbo.StatusCallFinish_change_status')->insert([
					'Id' => $data->Id,
					'idInList' => $data->idInList,
					'insertDateTime' => Carbon::now(),
					'idChain' => $data->idChain,
					'result' => $data->result,
					'TaskId' => $data->TaskId,
					'iduser' => Auth::user()->id_user
			]);

			if($dataCall->status_call_table != 'oktell.dbo.statuscallfinish')
			{
				$CustomTable = DB::connection('oktell')
					->table($dataCall->status_call_table)
					->where('IdChain',$idchain)
					->update(['result' => request('Result')]);
			}
			
			$CustomTable = DB::connection('oktell')
				->table('oktell.dbo.statuscallfinish')
				->where('IdChain',$idchain)
				->first();

			if($CustomTable != null)
			{
				$CustomTable = DB::connection('oktell')
					->table('oktell.dbo.statuscallfinish')
					->where('IdChain',$idchain)
					->update(['result' => request('Result')]);
			}
		
		
			if($Results->call_algorithm == 1 )
			{
				$status = 10;
				//dd($status);
			}
			if($Results->call_algorithm == 2 )
			{
				$status = 20;
				//dd($status);
			}
			if($Results->call_algorithm == 3 )
			{
				$status = 40;
				//dd($status);
			}
			if($Results->call_algorithm == 4 )
			{
				$status = 40;
				//dd($status);
			}
			if($Results->call_algorithm == 5 )
			{
				$status = 50;
				//dd($status);
			}
			if($Results->call_algorithm == 6 )
			{
				$status = 50;
				//dd($status);
			}

			$task_phone_data->update(['status' => $status]);
			$task_abonent_data->update(['status' => $status]);
		}
		
		return redirect()->route('searchChangeCompletionCode');
	}
}
