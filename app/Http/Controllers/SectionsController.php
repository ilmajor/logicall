<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Section;
use App\User;

class SectionsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}


	public function index()
	{
/*		$sections = Section::with(['projects','role']);
		$sections = $sections
			->where()
			->get();*/
/*		$sections = Section::with(['role','projects'])
			->whereIn('role_id',User::find(Auth::id())->roles->pluck('id'))
			->orderBy('role_id')
			->orderBy('title')
			->dd();*/
		//$sections = Section::with('projects.section_id')->get();

		 $sections = Section::whereIn('role_id',User::find(Auth::id())->roles->pluck('id'))
		 				->with('projects','role')
		 				->doesntHave('projects')
		                ->orWhereHas('projects', function ($query)  {
		                    $query->whereIn('project_section.project_id', User::find(Auth::id())->projects->pluck('id'));
		                })
        				->orderBy('role_id')
						->orderBy('title')
						->latest()
						->get();
		
/*		$query = Section::whereIn('role_id',User::find(Auth::id())->roles->pluck('id'))
			->orderBy('role_id')
			->orderBy('title')
			->latest();		
		if (!empty(User::find(Auth::id())->profiles->Project)){
			$query->orWhereIn('project', User::find(Auth::id())->projects->pluck('id'));
		}
		$sections = $query->get();*/
		//dd($sections);
		return view('welcome',compact([
			'sections'
		])
		);
	}

}
