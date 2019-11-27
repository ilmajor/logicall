<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
class RolesController extends Controller
{
	public function __construct()
	{
		#$this->middleware('auth');
		#$this->middleware('AuthAdmin');
	}

	public static function index()
	{
		$Roles = Role::orderBy('name')->get();
		return view('admin.role.index',compact('Roles'));
	}
	public static function show(Role $role)
	{
		return view('admin.role.show',compact(
			'role'
		));
	}
	public static function update(Role $role)
	{
	    $role->update(request()->except(['_method','_token']));
	    $role->save();
	    return redirect()->back();
	}
	public function create()
	{
		return view('admin.role.create');
	}
	public function store(){
		$this->validate(request(),[
		  'name' => 'required|min:3',
		  'description' => 'required',
		  'weight' => 'required',
		]);
		
		Role::create([
		  'name' => request('name'),
		  'description' => request('description'),
		  'weight' => request('weight'),
		]);
		return redirect()->back();
	}
	public function destroy(Role $role){
		$role->delete();
		return redirect()->back();
	}
}
