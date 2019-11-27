<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Users;
Use App\User;
use DB;
Use Illuminate\Support\Facades\Auth;
class WelcomeController extends Controller
{

  public function __construct()
  {
    #$this->middleware('auth');
  }

	public function index(Request $request)
	{
    
    $section = DB::connection('sqlsrv_srn')
      ->table('sections')
      ->get();
		return view('welcome',compact([
      'section'
    ]));

	}
}
