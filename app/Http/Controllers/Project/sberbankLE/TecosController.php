<?php

namespace App\Http\Controllers\Project\sberbankLE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\project\sberbankLE\Tecos;
use App\project\sberbankLE\TecosLogStart;
use App\project\sberbankLE\TecosLogStop;
use App\Task;
use App\User;
use DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class TecosController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('AuthManager');
    }

    public function index(){
    	$tasks = Tecos::Join('tasks','tasks.uuid','=','Tecos.uuid')
    		->get();
    	
		return view('project.sberbankLE.index',compact([
			'tasks',
		]));
    }
    public function show($id){
    	$task = Task::find($id);
    	
    	$tecos = Tecos::where('uuid','=',$task->uuid)
    		->first();

    	$baseSize = DB::connection('oktell')
            ->table($tecos->task_table)
    		->leftJoin($tecos->task_table_daily,$tecos->task_table_daily.'.id','=', $tecos->task_table.'.id')
    		->selectRaw(
    			$tecos->task_table.'.ID_CAMPAIGN 
    			,cast('.$tecos->task_table.'.insertdatetime as date) as dte
    			,count('.$tecos->task_table.'.id) as baseSize
    			,count('.$tecos->task_table_daily.'.id) as baseSizeDaily'
    		)
    		->groupBy($tecos->task_table.'.ID_CAMPAIGN',$tecos->task_table.'.insertdatetime')
    		->orderBy(DB::raw('cast('.$tecos->task_table.'.insertdatetime as date)'))
    		->get();

		return view('project.sberbankLE.task',compact([
			'baseSize',
			'task',
		]));
    }

    public function start($id, $id_campaign, $date){
        $user = User::find(Auth::id());
        $task = Task::find($id);
        $tecos = Tecos::where('uuid','=',$task->uuid)
            ->first();

        $log = TecosLogStart::firstOrNew([
            'ID_CAMPAIGN' => $id_campaign,
            'TaskId' => $task->uuid,
        ]);

        if ($log->exists) {
            TecosLogStart::create([
                'ID_CAMPAIGN' => $id_campaign,
                'insertDateTime' => Carbon::now(),
                'TaskId' => $task->uuid,
                'iduser' => $user->id_user,
                'done' => 2,
                'base_date'=>$date,
            ]);
        } else {
            TecosLogStart::create([
                'ID_CAMPAIGN' => $id_campaign,
                'insertDateTime' => Carbon::now(),
                'TaskId' => $task->uuid,
                'iduser' => $user->id_user,
                'done' => 0,
                'base_date'=>$date,
            ]);
        }

        $insert = DB::connection('oktell')
            ->insert(
                'insert into '. $tecos->task_table_daily .
                ' select *,getdate()
                from '. $tecos->task_table .'
                where ID_CAMPAIGN = :id_campaign
                and cast(insertdatetime as date) = :date
                and id not in (
                    select id from '. $tecos->task_table_daily 
                .') '
                ,[
                    'id_campaign' => $id_campaign,
                    'date' => $date,
                ]
            );

        return redirect()->back();
    }

    public function stopTemporarily($id, $id_campaign, $date){
        $user = User::find(Auth::id());
        $task = Task::find($id);
        $tecos = Tecos::where('uuid','=',$task->uuid)
            ->first();

        $log = TecosLogStop::create([
            'ID_CAMPAIGN' => $id_campaign,
            'insertDateTime' => Carbon::now(),
            'TaskId' => $task->uuid,
            'iduser' => $user->id_user,
            'done' => 2,
            'base_date'=>$date,
        ]);

        $delete = DB::connection('oktell')
            ->table($tecos->task_table_daily)
            ->where('ID_CAMPAIGN',$id_campaign)
            ->where(DB::raw('cast(insertdatetime as date)'),$date)
            ->delete();

        return redirect()->back();
    }

    public function stopForever($id, $id_campaign, $date){
        $user = User::find(Auth::id());
        $task = Task::find($id);
        $tecos = Tecos::where('uuid','=',$task->uuid)
            ->first();

        $log = TecosLogStop::create([
            'ID_CAMPAIGN' => $id_campaign,
            'insertDateTime' => Carbon::now(),
            'TaskId' => $task->uuid,
            'iduser' => $user->id_user,
            'done' => 0,
            'base_date'=>$date,
        ]);

        $delete = DB::connection('oktell')
            ->table($tecos->task_table_daily)
            ->where('ID_CAMPAIGN',$id_campaign)
            ->where(DB::raw('cast(insertdatetime as date)'),$date)
            ->delete();

        return redirect()->back();
    }
}
