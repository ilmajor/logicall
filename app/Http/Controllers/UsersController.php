<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
Use App\a_users;
Use Illuminate\Support\Facades\Auth;
Use App\User;
Use App\Role;

class UsersController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    //$this->middleware('AuthManager' , ['except' => 'show']);

  }
  
  public function show() 
  {

    $id = Auth::user()->id;

/*    $login = DB::connection('sqlsrv_srn')->select("
    select 
        UserName as UserName
        ,CONVERT(VARCHAR(32), HashBytes('MD5', [password]), 2) as [pswd]
        ,login as lg
        ,case when max([Operator]) = 1 then 'Да' else 'нет' end as [Operator]
        ,case when max([manager]) = 1 then 'Да' else 'нет' end  as [manager]
        ,case when max([admin]) = 1 then 'Да' else 'нет' end  as [admin]
        ,isnull(Prefix,'нет номера') as number
        ,operatorStatus as [operatorStatus]
    from (
      select
        u.[name] as UserName
        ,u.[login] as [login]
        ,u.id as id
        ,u.password as [password]
        ,case when r.role_id = 1 then 1 end as [Operator]
        ,case when r.role_id = 2 then 1 end as [manager]
        ,case when r.role_id = 3 then 1 end as [admin]
        ,id_user
        ,case when IsDeleted = 1 then 'Уволен' else 'Действующий сотрудник' end operatorStatus
      from [logicall].dbo.Users u with(nolock)
      left join [logicall].dbo.role_user r with(nolock) on r.[user_id] = u.id
      left join [logicall].dbo.roles n with(nolock) on n.id = r.role_id
      left join oktell.dbo.A_Users a with(nolock) on a.ID = u.id_user
      where n.[name] is not null
    ) as t
    left join (
      select 
        Prefix
        ,rr.ReactID
        ,name
      from oktell.dbo.[A_RuleRecords] rr with(nolock)
      left join oktell.dbo.[A_Rules] r with(nolock) on rr.RuleID = r.ID
      left join oktell.dbo.[A_NumberPlanAction] npa with(nolock) on npa.ExtraID = r.ID
      left join oktell.dbo.[A_NumberPlan] np with(nolock) on np.ID = npa.NumID
    ) n on n.ReactID = t.id_user and n.Name =  t.UserName
    where id = :id
    group by UserName,[login],id,[password],Prefix,operatorStatus
    ", ['id'=> $id]);
    foreach ($login as $key) {
      $result['username'] = $key->UserName;
      $result['password'] = $key->pswd;
      $result['login'] = $key->lg;
      $result['operator'] = $key->Operator;
      $result['manager'] = $key->manager;
      $result['admin'] = $key->admin;
      $result['number'] = $key->number;
      $result['operatorStatus'] = $key->operatorStatus;
    };*/
    $user = User::find($id);
    $profile = $user->profiles;
    $roles = $user->roles->pluck('name','name');
    $projects = $user->projects->pluck('name','name');;
    $prefix = DB::connection('sqlsrv_srn')
      ->table('logicall.dbo.users')
      ->leftJoin('oktell.dbo.A_RuleRecords', 'A_RuleRecords.ReactID', '=', 'users.id_user')
      ->leftJoin('oktell.dbo.A_Rules', 'A_Rules.ID', '=', 'A_RuleRecords.RuleID')
      ->leftJoin('oktell.dbo.A_NumberPlanAction', 'A_NumberPlanAction.ExtraID', '=', 'A_Rules.ID')
      ->leftJoin('oktell.dbo.A_NumberPlan', 'A_NumberPlan.ID', '=', 'A_NumberPlanAction.NumID')
      ->where('users.id', '=', $id)
      ->select('users.*', 'Prefix')
      ->first();

    //dd($profile->DateofBirth);
    return view('users.info',compact([
      'user',
      'profile',
      'roles',
      'prefix',
      'projects',
    ]));

  }


}
