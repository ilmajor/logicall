<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class IndexController extends Controller
{
  public function __construct()
  {
    #$this->middleware('auth');
    #$this->middleware('AuthAdmin');

  }

 public static function index()
  {
     return view('admin.welcome');
  }
}
