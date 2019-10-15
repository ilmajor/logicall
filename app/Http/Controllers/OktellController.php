<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\User;
use App\Role;
use App\Profile;
use App\Project;
use App\OktellUserControl;
use Illuminate\Support\Facades\Auth;

class OktellController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('AuthManager');
  }
  public function createUser()
  {
    return view('users.create');
  }

  public function storeUser()
  {
    $this->validate(request(),[
      'Surname' => 'required|min:3',
      'Name' => 'required|min:3',
      'middleName' => 'required|min:3',
    ]);
    $Surname = trim(request('Surname'));
    $Name = trim(request('Name'));
    $middleName = trim(request('middleName'));
    $fio = $Surname.' '.$Name.' '.$middleName;
    $login = $Surname.mb_substr($Name,0,1,"UTF-8").mb_substr($middleName,0,1,"UTF-8");
    $idUser = collect(\DB::connection('sqlsrv_srn')->select('select NEWID() as id'))->first();

    $user = User::create([
      'name' => $fio,
      'login' => $login,
      'password' => mb_strtoupper(md5(mb_convert_encoding($login,'cp1251'))),
      'id_user' => $idUser->id,
    ]);

    $user
      ->roles()
      ->attach(Role::where('name', 'Operator')->first()); 

    $profile = Profile::create([
      'user_id' => $user->id,
      'FullName' => $user->name,
    ]);

    $data = DB::connection('oktell')->select("
      exec [oktell].[dbo].[usp_create_user] 
      :name
      , :login
      , :idUser
      ",[
      'name' => $fio,
      'login' => $login,
      'idUser' => $idUser->id
    ]);

    return view('users.create',compact([
      'data'
    ]));
  }

  public function indexUser()
  {
    $data = Role::where('weight','>',User::find(Auth::id())->roles->max('weight'))
      ->with('users')
      ->first();
    
    $users = User::join('oktell.dbo.A_users', function ($join) {
        $join->on('users.id_user', '=', 'A_users.id');
      })
      ->orWhereHas('roles', function ($query) use($data)  {
        $query->where('roles.weight' ,'<=' , User::find(Auth::id())->roles->max('weight'))
        ->whereNotIn(
            'role_user.user_id'
            ,$data !== null ? $data->users->pluck('id') : [0]
          );
      })
      ->orderBy('users.name','asc')
      ->get();
    return view('users.index',compact('users'));
  }

  public function showUser($id)
  {
    $rights = Role::where('weight','>',User::find(Auth::id())->roles->max('weight'))
      ->with('users')
      ->first();
    
    $users = User::join('oktell.dbo.A_users', function ($join) {
        $join->on('users.id_user', '=', 'A_users.id');
      })
      ->orWhereHas('roles', function ($query) use($rights)  {
        $query->where('roles.weight' ,'<=' , User::find(Auth::id())->roles->max('weight'))
        ->whereNotIn(
            'role_user.user_id'
            ,$rights !== null ? $rights->users->pluck('id') : [0]
          );
      })
      ->where('IsDeleted',0)
      ->orderBy('users.name','asc')
      ->get(); 

    $data = User::find($id);
    $roleWeight = $data->roles->max('weight');
    //$managers = Role::find(2)->users;


    $managers = User::whereHas('roles', function ($query) {
        $query->whereIn('roles.id' ,[2,1002]);
      })
      ->orderBy('users.name','asc')
      ->get();
    $projects = Project::orderBy('name')->get();
    $profile = Profile::where('user_id',$id)->first();
    $userProjects = $data->projects->pluck('id')->toArray();
    $prefix = DB::connection('sqlsrv_srn')
      ->table('logicall.dbo.users')
      ->leftJoin('oktell.dbo.A_RuleRecords', 'A_RuleRecords.ReactID', '=', 'users.id_user')
      ->leftJoin('oktell.dbo.A_Rules', 'A_Rules.ID', '=', 'A_RuleRecords.RuleID')
      ->leftJoin('oktell.dbo.A_NumberPlanAction', 'A_NumberPlanAction.ExtraID', '=', 'A_Rules.ID')
      ->leftJoin('oktell.dbo.A_NumberPlan', 'A_NumberPlan.ID', '=', 'A_NumberPlanAction.NumID')
      ->where('users.id', '=', $id)
      ->select('users.*', 'Prefix')
      ->first();
    $userRoleWeight = User::find(Auth::id())->roles->max('weight');

    $UsersUnderControl = OktellUserControl::where('UserA',$data->id_user)->select('UserB')->get();
    $UsersUnderControl = $UsersUnderControl->pluck('UserB')->toArray();

    $UsersControl =  OktellUserControl::where('UserB',$data->id_user)->select('UserA')->get();
    $UsersControl = $UsersControl->pluck('UserA')->toArray();

    return view('users.show',compact([
      'profile',
      'data',
      'projects',
      'managers',
      'prefix',
      'userProjects',
      'roleWeight',
      'userRoleWeight',
      'users',
      'UsersUnderControl',
      'UsersControl'
    ]));
  }

  public function updateUser($id){
    $user = User::find($id);
    // UserA еонтролирует UserB подчиняется
    $OktellUserAControls = OktellUserControl::where('UserA',$user->id_user)
      ->get();
    $OktellUserBControls = OktellUserControl::where('UserB',$user->id_user)
      ->get();
    $OktellUserAControls = $OktellUserAControls->pluck('UserB')->toArray();
    $OktellUserBControls = $OktellUserBControls->pluck('UserA')->toArray();
    $UsersA = request()->input('UserA');
    $UsersB = request()->input('UserB');
            
    OktellUserControl::where('UserA',$user->id_user)
      ->delete();

    OktellUserControl::where('UserB',$user->id_user)
      ->delete();

    if(!empty($UsersA)){
      foreach ($UsersA as $UserA) {

        //if(!in_array($UserA, $OktellUserBControls)){
          $OktellUserControl = New OktellUserControl;
          $OktellUserControl->UserA = $UserA;
          $OktellUserControl->UserB = $user->id_user;
          $OktellUserControl->save();


        //}
      }
    }
    if(!empty($UsersB)){
      foreach ($UsersB as $UserB) {
        //if(!in_array($UserB, $OktellUserAControls)){
          $OktellUserControl = New OktellUserControl;
          $OktellUserControl->UserB = $UserB;
          $OktellUserControl->UserA = $user->id_user;
          $OktellUserControl->save();
        //}
      }
    }



    $Profile = Profile::where('user_id', $id)->first();
    $Profile->update(request()->except(['_method','_token','project','UserA','UserB']));
    $Profile->save();
    
    $log = $user->projects()->sync(request()->input('project'));
    activity()
      ->performedOn($user)
      ->causedBy(auth()->user())
      ->withProperties($log)
      ->log(':causer.name changed sites for :subject.title');
    activity()
      ->performedOn($user)
      ->causedBy(auth()->user())
      ->performedOn($OktellUserControl)
      ->withProperties($UsersA)
      ->log(':causer.name changed UsersA. Old users');
    activity()
      ->performedOn($user)
      ->causedBy(auth()->user())
      ->performedOn($OktellUserControl)
      ->withProperties($OktellUserAControls)
      ->log(':causer.name changed UsersA. New users');
    activity()
      ->performedOn($user)
      ->causedBy(auth()->user())
      ->performedOn($OktellUserControl)
      ->withProperties($OktellUserBControls)
      ->log(':causer.name changed UsersB. Old users');
    activity()
      ->performedOn($user)
      ->causedBy(auth()->user())
      ->performedOn($OktellUserControl)
      ->withProperties($UsersB)
      ->log(':causer.name changed UsersB. New users');

    return redirect()->back();
    
  }

}