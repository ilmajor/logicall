<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use App\Models\City;
Use App\Models\User;
use Illuminate\Support\Str;
use App\Repositories\Users;

class CityController extends Controller
{
	public function __construct()
	{
		#$this->middleware('auth');
		#$this->middleware('AuthAdmin');
	}

	public function index()
	{
		$city = City::orderBy('name')->get();
		
		return view('city.index',compact([
			'city'
		]));
	} 

	public function show(City $city, Users $users)
	{
		$managers = $users::getUserByRole(['manager']);
		return view('city.show',compact(
			'city',
			'managers'
		));
	}

	public function update(City $city)
	{
		$city->update(request()->except(['_method','_token']));
		$city->save();
		return redirect()->back();
	}

	public function create()
	{
		$managers = User::whereHas('roles', function ($query) {
				$query->whereIn('roles.id' ,[2]);
			})
		->orderBy('users.name','asc')
		->get();

		return view('city.create',compact([
			'managers'
		]));
	}

	public function store()
	{
		$this->validate(request(),[
			'name' => 'required',
			'director' => 'required',
			'address' => 'required',
		]);
		$city = new City;
		$city->uuid = (string) Str::uuid();
		$city->fill(request()->except(['_method','_token']));
		$city->save();
		return redirect()->back();
	}

	public function destroy(City $city)
	{
		$city->delete();
		return redirect()->back();
	}
}
