<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use App\ContractingOrganization;
Use App\User;
use Illuminate\Support\Str;

class ContractingOrganizationController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('AuthAdmin');
	}
	public static function index()
	{
		$ContractingOrganizations = ContractingOrganization::orderBy('name')->get();
		return view('admin.ContractingOrganization.index',compact([
			'ContractingOrganizations'
		]));
	}

	public static function show($id)
	{
		$ContractingOrganization = ContractingOrganization::find($id)->first();
		return view('admin.ContractingOrganization.show',compact(
			'ContractingOrganization'
		));
	}

	public static function update($id)
	{
		$ContractingOrganization = ContractingOrganization::find($id);
		$ContractingOrganization->update(request()->except(['_method','_token']));
		$ContractingOrganization->save();
		return redirect()->back();
	}

	public function create()
	{	
		return view('admin.ContractingOrganization.create');
	}

	public function store(){
		$this->validate(request(),[
			'name' => 'required'
		]);

		$ContractingOrganization = new ContractingOrganization;
		$ContractingOrganization->uuid = (string) Str::uuid();
		$ContractingOrganization->fill(request()->except(['_method','_token']));
		$ContractingOrganization->save();
		return redirect()->back();
		
	}

	public function destroy($id){
		ContractingOrganization::find($id)->delete();
		return redirect()->back();
	}
}
