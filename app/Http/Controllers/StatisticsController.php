<?php

namespace App\Http\Controllers;
use DB;

Use Illuminate\Support\Facades\Auth;
Use App\Models\User;
Use App\Models\Role;
use Illuminate\Support\Arr;

use Illuminate\Http\Request;

class StatisticsController extends Controller
{
  public function __construct()
  {
    #$this->middleware('auth');
    #$this->middleware('guest',['except' => 'destroy']);
  }

  public function show()
  {
    return view('statistics.index');
  }

  public function send()
  {
    $timeout = 600000;
    
    $timeWorked = DB::select("
      exec [usp_lk_timeWorked] :dateBegin, :dateEnd, :userId
      ", [
        'dateBegin' => date('Y-m-d'),
        'dateEnd' => date('Y-m-d'),
        'userId' => Auth::user()->id_user
    ]);
 
    $callsInformation = DB::select("
      exec [usp_lk_callsInformation] :dateBegin, :dateEnd, :userId
      ", [

        'dateBegin' => date('Y-m-d'),
        'dateEnd' => date('Y-m-d'),
        'userId' => Auth::user()->id_user
    ]);

    $callConsent = DB::select("
      exec [usp_lk_callConsent] :dateBegin, :dateEnd, :userId
      ", [

        'dateBegin' => date('Y-m-d'),
        'dateEnd' => date('Y-m-d'),
        'userId' => Auth::user()->id_user
    ]);
      
  return response()->json(array(
      'timeWorked'=> $timeWorked,
      'callsInformation'=> $callsInformation,
      'callConsent'=> $callConsent
    ), 200);
  }
}
