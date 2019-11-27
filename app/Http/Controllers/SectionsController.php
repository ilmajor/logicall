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
	#$this->middleware('auth');
}

public function index()
{
//dd(request());
	$sections = Section::leftJoin('role_section','role_section.section_id','=','Sections.id')
		->leftJoin('project_section','project_section.section_id','=','Sections.id')
		->whereIn('role_section.role_id', User::find(Auth::id())->roles->pluck('id'))
		->where(function ($query)  {		
			$query->whereIn('project_section.project_id',User::find(Auth::id())->projects->pluck('id'))
				->orWhereNull('project_section.project_id');
		})
		->groupBy('sections.title','sections.id','sections.description','sections.url')
		->select('sections.title','sections.id','sections.description','sections.url')
		->selectRaw('max(role_section.role_id) as role_id')
		->orderBy('title')
		->get();

	$sections = $sections->sortBy('role_id');
	return view('welcome',compact([
		'sections'
	]));
	} 

}
