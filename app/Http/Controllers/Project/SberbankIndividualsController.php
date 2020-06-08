'<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DB;
use Carbon\Carbon;
use App\Models\project\sberbankIndividuals\SberbankIndividualsRequireFU;


class SberbankIndividualsController extends Controller
{

	public function __construct()
	{
		##$this->middleware('auth');
	}
	public function index()
	{
		
		return view('project.sberbank.pretensionFU');
	}
	public function store()
	{
		$this->validate(request(),[
			'dataCall' => 'required',
			'webId' => 'required',
			'idClient' => 'required',
			'product' => 'required',
			'validity' => 'required',
			'appStatus' => 'required',
			'comment' => 'required',
			'addressVsp' => 'required',
		]);

		$data = SberbankIndividualsRequireFU::create([
			'dataCall' => request('dataCall'),
			'webId' => request('webId'),
			'idClient' => request('idClient'),
			'product' => request('product'),
			'validity' => request('validity'),
			'appStatus' => request('appStatus'),
			'comment' => request('comment'),
			'addressVsp' => request('addressVsp'),
			'user_id' => User::find(Auth::id())->id_user,
			'timestamps' =>  Carbon::now(),
			'created_at' =>  Carbon::now(),
		]);

		return redirect()->back();
	}
}
