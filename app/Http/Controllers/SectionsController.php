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
		$query = Section::whereIn('role_id',User::find(Auth::id())->roles->pluck('id'))
			->whereNull('project')
			->orderBy('role_id')
			->orderBy('title')
			->latest();
		
		if (!empty(User::find(Auth::id())->profiles->Project)){
			$query->orWhereIn('project', User::find(Auth::id())->profiles->Project);
		}
		$sections = $query->get();
		return view('welcome',compact([
			'sections'
		])
		);
	}

}
