<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use Illuminate\Support\Facades\Auth;
Use App\User;
Use App\Role;
class UsersController extends Controller
{
	public function __construct()
	{
		#$this->middleware('auth');
		#$this->middleware('AuthAdmin');
	}

	public static function index()
	{
		$Users = User::orderBy('name')->get();
		return view('admin.user.index',compact('Users'));
	}
	public static function show(User $User)
	{
		$UserRoles = $User->roles;
		$Roles = Role::get();
		return view('admin.user.show',compact(
			'User'
			,'UserRoles'
			,'Roles'
		));
	}
	public static function update(User $User)
	{
	    $log = $User->roles()->sync(request()->input('role'));
	    
		activity()
		    ->performedOn($user)
		    ->causedBy(auth()->user())
		    ->withProperties($log)
		    ->log(':causer.name changed sites for :subject.title');
	    return redirect()->back();
	}
}
