<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use App\Project;
Use App\User;
class ProjectController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('AuthAdmin');
	}

	public static function index()
	{
		$project = Project::orderBy('name')->get();
		return view('admin.project.index',compact([
			'project'
		]));
	}

	public static function show($id)
	{
		$managers = User::whereHas('roles', function ($query) {
				$query->whereIn('roles.id' ,[2]);
			})
		->orderBy('users.name','asc')
		->get();
		
		$project = Project::find($id)->first();


		return view('admin.project.show',compact(
			'project'
			,'managers'
		));
	}

	public static function update($id)
	{
		$project = Project::find($id);
		$project->update(request()->except(['_method','_token']));
		$project->save();
		return redirect()->back();
	}

}


