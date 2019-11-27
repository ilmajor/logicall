<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use App\City;
Use App\User;
use Illuminate\Support\Str;

class CityController extends Controller
{
	public function __construct()
	{
		#$this->middleware('auth');
		#$this->middleware('AuthAdmin');
	}
	public static function index()
	{
		$city = City::orderBy('name')->get();

		return view('admin.city.index',compact([
			'city'
		]));
	}

	public static function show(City $city)
	{
		$managers = User::whereHas('roles', function ($query) {
				$query->whereIn('roles.id' ,[2]);
			})
		->orderBy('users.name','asc')
		->get();
		
		return view('admin.city.show',compact(
			'city',
			'managers'
		));
	}

	public static function update(City $city)
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

		return view('admin.city.create',compact([
			'managers'
		]));
	}

	public function store(){
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

	public function destroy(City $city){
		$city->delete();
		return redirect()->back();
	}
	
}
