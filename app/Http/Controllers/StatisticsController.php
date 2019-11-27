<?php

namespace App\Http\Controllers;
use DB;

Use Illuminate\Support\Facades\Auth;
Use App\User;
Use App\Role;
use Illuminate\Support\Arr;

use Illuminate\Http\Request;

class StatisticsController extends Controller
{
  public function __construct()
  {
    #$this->middleware('auth');
  }


  public function show()
  {
    return view('statistics.index');
  }

  public function send()
  {
    $timeWorked = DB::connection('sqlsrv_srn')->select("
      exec [usp_lk_timeWorked] :dateBegin, :dateEnd, :userId
      ", [
        'dateBegin' => date('Y-m-d'),
        'dateEnd' => date('Y-m-d'),
        'userId' => Auth::user()->id_user
    ]);

    $data = Arr::first(data_get($timeWorked, '*.timeWorked'), function ($value, $key) {
        return $value > 0;
    });
    if (empty($data))
    {
       $timeWorked = [];
    }
    

    $callsInformation = DB::connection('sqlsrv_srn')->select("
      exec [usp_lk_callsInformation] :dateBegin, :dateEnd, :userId
      ", [

        'dateBegin' => date('Y-m-d'),
        'dateEnd' => date('Y-m-d'),
        'userId' => Auth::user()->id_user
    ]);

    $data = Arr::first(data_get($callsInformation, '*.calls'), function ($value, $key) {
        return $value > 0;
    });
    if (empty($data))
    {
       $callsInformation = [];
    }


    $callConsent = DB::connection('sqlsrv_srn')->select("
      exec [usp_lk_callConsent] :dateBegin, :dateEnd, :userId
      ", [

        'dateBegin' => date('Y-m-d'),
        'dateEnd' => date('Y-m-d'),
        'userId' => Auth::user()->id_user
    ]);

    $data = Arr::first(data_get($callConsent, '*.calls'), function ($value, $key) {
        return $value > 0;
    });
    if (empty($data))
    {
       $callConsent = [];
    }
    
/*    return view('statistics.index',compact([
        'callsInformation'
        ,'timeWorked'
        ,'callConsent'
      ]));*/

      
  return response()->json(array(
      'timeWorked'=> $timeWorked,
      'callsInformation'=> $callsInformation,
      'callConsent'=> $callConsent
    ), 200);

  }
}
