<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CustomerDashboard;
use App\Models\Project;

class CustomerDashboardController extends Controller
{

	public static function index()
	{
		$CustomerDashboards = CustomerDashboard::orderBy('name')->get();

		return view('admin.CustomerDashboard.index',compact([
			'CustomerDashboards'
		]));
	}

	public function create()
	{	
		$Projects = Project::select('id','Name')->get();
		
		return view('admin.CustomerDashboard.create',compact([
			'Projects'
		]));
	}

	public function store(){
		$this->validate(request(),[
			'name' => 'required',
			'query' => 'required',
			'charts' => 'required',
			'project_id' => 'required',
			'timeout' => 'required'
		]);
		
		$CustomerDashboard = new CustomerDashboard;
		$CustomerDashboard->fill(request()->except(['_method','_token']));
		$CustomerDashboard->save();

		return redirect()->route('adminCustomerDashboards');
	}

	public static function update(CustomerDashboard $CustomerDashboard)
	{
		$CustomerDashboard->update(request()->except(['_method','_token']));
		$CustomerDashboard->save();
		return redirect()->route('adminCustomerDashboards');
	}

	public function destroy(CustomerDashboard $CustomerDashboard){
		$CustomerDashboard->delete();
		return redirect()->route('adminCustomerDashboards');
	}

	public static function show(CustomerDashboard $CustomerDashboard)
	{
		$Projects = Project::select('id','Name')
			->get();
		
		return view('admin.CustomerDashboard.show',compact(
			'CustomerDashboard',
			'Projects'
		));
	}

}
