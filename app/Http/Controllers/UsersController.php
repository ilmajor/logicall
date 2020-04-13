<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
Use Illuminate\Support\Facades\Auth;
Use App\Models\User;
use App\Repositories\Users;
use App\Models\Role;
use App\Models\Profile;
use App\Models\Project;
use App\Models\OktellUserControl;
use App\Models\City;
use App\Models\ContractingOrganization;
use App\Models\OktellPlugin;

#use App\Http\Controllers\Controller;

class UsersController extends Controller
{
  public function __construct()
  {
    #$this->middleware('auth');
    //$this->middleware('AuthManager' , ['except' => 'show']);

  }

  public function showOwnerData(Users $users) 
  {
    $user = User::find(Auth::id());
    $profile = $user->profiles;
    $roles = $user->roles->pluck('name','name');
    $projects = $user->projects->pluck('name','name');;
    $prefix = $users->getUserOktellNumber($user->id);
    return view('users.info',compact([
      'user',
      'profile',
      'roles',
      'prefix',
      'projects',
    ]));
  }

  public function index()
  {
    $data = Role::UsersMaxWeight(Auth::id());

    $currentUsers = User::join('oktell_settings.dbo.A_Users', function ($join) {
            $join->on('users.id_user', '=', 'A_Users.id');
          })
          ->orWhereHas('roles', function ($query) use($data)  {
            $query->where('roles.weight' ,'<=' , User::find(Auth::id())->roles->max('weight'))
          ->whereNotIn(
            'role_user.user_id'
            ,$data !== null ? $data->users->pluck('id') : [0]
          );
          })
          ->where("IsDeleted",0)
          ->orderBy('users.name','asc')
          ->select("Users.*")
          ->paginate(100);

    $firedUsers = User::join('oktell_settings.dbo.A_Users', function ($join) {
            $join->on('users.id_user', '=', 'A_Users.id');
          })
          ->orWhereHas('roles', function ($query) use($data)  {
            $query->where('roles.weight' ,'<=' , User::find(Auth::id())->roles->max('weight'))
          ->whereNotIn(
            'role_user.user_id'
            ,$data !== null ? $data->users->pluck('id') : [0]
          );
          })
          ->where("IsDeleted",1)
          ->orderBy('users.name','asc')
          ->select("Users.*")
          ->paginate(100);


    return view('users.index',compact('currentUsers','firedUsers'));
  }

  public function create()
  {
    return view('users.create');
  }

  public function store()
  {
    $this->validate(request(),[
      'Surname' => 'required|min:3',
      'Name' => 'required|min:3',
      'middleName' => 'required|min:3'
    ]);
    $Surname = trim(request('Surname'));
    $Name = trim(request('Name'));
    $middleName = trim(request('middleName'));
    $password = trim(request('password'));

    $fio = $Surname.' '.$Name.' '.$middleName;
    $login = $Surname.mb_substr($Name,0,1,"UTF-8").mb_substr($middleName,0,1,"UTF-8");
    $idUser = collect(\DB::connection('sqlsrv_srn')->select('select NEWID() as id'))->first();
    $password = !empty($password) ? $password : $login;
    $password = mb_strtoupper(md5(mb_convert_encoding($password,'cp1251')));
    #dd($password);
    $user = User::create([
      'name' => $fio,
      'login' => $login,
      'password' => $password,
      'id_user' => $idUser->id,
    ]);

    $user->roles()->attach(Role::where('name', 'Operator')->first()); 

    $profile = Profile::create([
      'user_id' => $user->id,
      'FullName' => $user->name,
    ]);


    $data = DB::connection('oktell')->select("
      exec [oktell].[dbo].[usp_create_user_v2] 
      :name
      , :login
      , :idUser
      , :password
      ",[
      'name' => $fio,
      'login' => $login,
      'idUser' => $idUser->id,
      'password' => $password
    ]);

    return redirect()->route('user', ['id' => $user->id]);
  }

public function show(Users $users, User $user)
  {

    //$this->authorize('role',$user->roles()->orderBy('weight','desc')->first());

    $this->authorize('profileAccess', $user, $user);
    $userWithLargeRights = Role::UsersMaxWeight(Auth::id());
    $roleWeight = $user->roles->max('weight');
    $managers = $users->getUserByRole(['manager','supervisor']);
    $prefix = $users->getUserOktellNumber($user->id);

    $usersList = User::LeftJoin('oktell_settings.dbo.A_Users', function ($join) {
        $join->on('users.id_user', '=', 'A_users.id');
      })
      ->orWhereHas('roles', function ($query) {
        $query->where('roles.weight' ,'<' , User::find(Auth::id())->roles->max('weight'))
          ->orWhere('users.id', '=', Auth::id());
      })
      ->WhereHas('roles', function ($query) use($userWithLargeRights)  {
        $query->whereNotIn(
            'role_user.user_id'
            ,$userWithLargeRights !== null ? $userWithLargeRights->users->pluck('id') : [0]
          );
      })
      ->where('IsDeleted',0) 
      ->where('users.id','!=',$user->id)
      ->orderBy('users.name','asc')
      ->get();

    $projects = Project::orderBy('name')->get();
    $profile = Profile::where('user_id',$user->id)->with('city')->first();
    $cities = City::orderBy('name')->get();
    $userProjects = $user->projects->pluck('id')->toArray();

    $userRoleWeight = Auth::user()->roles->max('weight');

    $UsersUnderControl = OktellUserControl::where('UserA',$user->id_user)
      ->get()
      ->pluck('UserB')
      ->toArray();

    $UsersControl = OktellUserControl::where('UserB',$user->id_user)
      ->get()
      ->pluck('UserA')
      ->toArray();

    $ContractingOrganizations = ContractingOrganization::orderBy('name')->get();

    $OktellPlugins = DB::table('oktell_settings.dbo.A_PluginMenu')
      ->select('Id','MenuText')
      ->orderBy('MenuText')
      ->get();

    $UserInOktellPlugins = DB::table('oktell_settings.dbo.A_PluginMenu_User')
      ->select('IdMenuLink')
      ->where('IdUser',$user->id_user)
      ->groupBy('IdMenuLink')
      ->get()
      ->pluck('IdMenuLink')
      ->toArray();

    return view('users.show',compact([
      'profile',
      'user',
      'projects',
      'managers',
      'prefix',
      'userProjects',
      'roleWeight',
      'userRoleWeight',
      'usersList',
      'UsersUnderControl',
      'UsersControl',
      'cities',
      'ContractingOrganizations',
      'OktellPlugins',
      'UserInOktellPlugins'
    ]));
  }

  public function update(User $user)
  {
    
    OktellPlugin::where('IdUser',$user->id_user)
      ->delete();
    $OktellPlugins = request()->input('OktellPlugins');

    if( request()->has('OktellPlugins')) {
      foreach ($OktellPlugins as $Plugin) {
        if(!empty($Plugin)){
          $OktellPlugin = New OktellPlugin;
          $OktellPlugin->IdUser = $user->id_user;
          $OktellPlugin->IdMenuLink = $Plugin;
          $OktellPlugin->Visible = 1;
          $OktellPlugin->save();
        }
      }
    }
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
    $Profile = Profile::where('user_id', $user->id)->first();
    $Profile->update(request()->except(['_method','_token','project','UserA','UserB','OktellPlugins']));
    $Profile->save();
    
    $log = $user->projects()->sync(request()->input('project'));
    activity()
      ->performedOn($user)
      ->causedBy(auth()->user())
      ->withProperties($log)
      ->log(':causer.name changed sites for :subject.title');
    if(!empty($OktellUserControl)){
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
    }
    return redirect()->back();
  }

}
