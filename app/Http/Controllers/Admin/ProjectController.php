<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use App\Models\Project;
Use App\Models\User;
use App\Repositories\Users;

class ProjectController extends Controller
{
	public function __construct()
	{
		#$this->middleware('auth');
		#$this->middleware('AuthAdmin');
	}

	public function index()
	{
		$project = Project::orderBy('name')->get();
		return view('admin.project.index',compact([
			'project'
		]));
	}

	public function show(Project $project, Users $users)
	{
		$managers = $users::getUserByRole(['manager']);;

		return view('admin.project.show',compact(
			'project'
			,'managers'
		));
	}

	public function update(Project $project)
	{
		$project->update(request()->except(['_method','_token']));
		$project->is_enabled = request()->input('is_enabled');
		$project->save();

		return redirect()->back();
	}
}


