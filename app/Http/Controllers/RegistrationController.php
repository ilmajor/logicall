<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\User;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('AuthManager');
    }
    public function create()
    {
    	return view('registration.create');
    }
    public function store()
    {
    	
    	$this->validate(request(),[
    		'name' => 'required',
    		'login' => 'required',
    		'password' => 'required',
    		'id_user' => 'required|string|min:36'
    		
    	]);
        $user = User::create([ 
            'name' => request('name'),
            'login' => request('login'),
            'password' => md5(mb_convert_encoding(request('password'),'cp1251')),
            'id_user' => request('id_user')
        ]);
        $user
           ->roles()
           ->attach(Role::where('name', 'Operator')->first());
   
    	auth()->login($user);
        
    	return redirect()->home();
    }
}
