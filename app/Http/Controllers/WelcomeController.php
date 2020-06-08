<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\User;
use DB;
Use Illuminate\Support\Facades\Auth;


class WelcomeController extends Controller
{

  public function __construct()
  {
    #$this->middleware('auth');
  }

	public function index()
	{


	}
}
