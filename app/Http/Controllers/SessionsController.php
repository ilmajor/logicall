<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
	public function __construct()
	{
		$this->middleware('guest',['except' => 'destroy']);
	}

	public function create()
	{
		return view('sessions.create');
	}

	public function store()
	{

		$data = [];
		$data['login'] = request('login');
		$data['password'] = request('password');
		$remember = request('remember');
		if(! Auth::attempt($data,($remember == 'on') ? true : false))
		{
			return back()->withErrors([
				'massage' => 'Проверьте данные'
			]);
		}
		return redirect()->home();
	}

	public function destroy()
	{
		auth()->logout();
		return redirect()->home();
	}
}
