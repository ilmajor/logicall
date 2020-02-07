<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Users;

use DB;
use Carbon\Carbon;

use App\Models\Role;
use App\Models\Profile;
use App\Models\Project;
use App\Models\OktellUserControl;
use App\Models\City;
use App\Models\ContractingOrganization;
use Illuminate\Support\Facades\Auth;


class OktellController extends Controller
{

  public function __construct()
  {
    #$this->middleware('auth');
    #$this->middleware('AuthManager');
  }

  

}