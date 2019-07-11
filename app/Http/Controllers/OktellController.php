<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\User;
use App\Role;
use App\Profile;
class OktellController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('AuthAdmin');

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

    #$profile = New Profile;
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
    $users = User::join('oktell.dbo.A_users', function ($join) {
            $join->on('users.id_user', '=', 'A_users.id');
        })
        ->orderBy('users.name','asc')
        ->get();

    return view('users.index',compact('users'));
  }

  public function showUser($id)
  {
    $data = User::find($id);
    $trainers = Role::find(2)->users;
    $projects = DB::connection('sqlsrv_srn')
      ->table('oktell_settings.dbo.A_TaskManager_Projects')
      ->orderBy('name','asc')
      ->get();
    $profile = $data->profiles;
#    dd($profile->Project);
    $prefix = DB::connection('sqlsrv_srn')
      ->table('logicall.dbo.users')
      ->leftJoin('oktell.dbo.A_RuleRecords', 'A_RuleRecords.ReactID', '=', 'users.id_user')
      ->leftJoin('oktell.dbo.A_Rules', 'A_Rules.ID', '=', 'A_RuleRecords.RuleID')
      ->leftJoin('oktell.dbo.A_NumberPlanAction', 'A_NumberPlanAction.ExtraID', '=', 'A_Rules.ID')
      ->leftJoin('oktell.dbo.A_NumberPlan', 'A_NumberPlan.ID', '=', 'A_NumberPlanAction.NumID')
      ->where('users.id', '=', $id)
      ->select('users.*', 'Prefix')
      ->first();
    #dd($profile);
    return view('users.show',compact([
      'profile',
      'data',
      'projects',
      'trainers',
      'prefix'
    ]));
  }

  public function updateUser($id){

    $Profile = Profile::where('user_id', $id)->first();
    $Profile->update(request()->except(['_method','_token','Project']));
    $Profile->Project = request()->Project;
    $Profile->save();
    return redirect()->back();

  }

}