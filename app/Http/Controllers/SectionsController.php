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

	return view('welcome',compact([
		'sections'
	]));
	}

}
