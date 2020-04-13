<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\User;

class SectionsController extends Controller
{
	public function __construct()
	{
		#$this->middleware('auth');
	}

	public function index()
	{
		$sections = Section::available(Auth::id());
		$sections = $sections->sortBy('role_id');
		return view('welcome',compact([
			'sections'
		]));
	}

	public function store()
	{
		
		dd(is_numeric(request('browser')));
		dd(request('browser'));
	}
}
