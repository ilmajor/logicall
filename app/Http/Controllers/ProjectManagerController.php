<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\OktellSetting;
use App\Models\CustomerDashboard;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Arr;
use App\Charts\PieChart;

class ProjectManagerController extends Controller
{
	public function index()
	{
		$projects = Project::whereIn('id',Auth::user()->projects->pluck('id'))
			->withCount('users')
			->orderBy('name')
			->get();

		return view('ProjectManager.index',compact([
			'projects'
		]));
	}
	
	public function show(Project $project)
	{

		$CustomerDashboards = CustomerDashboard::where('project_id',$project->id)->get();
		//$project = Project::find($CustomerDashboards->pluck('project_id'))->pluck('name');
		foreach($CustomerDashboards as $dashboard)
		{
			$data = DB::select($dashboard->query);
			$attributes = collect();
			$api = url('/CustomerDashboard/'.$dashboard->id);

			$timeouts[$dashboard->id] = $dashboard->timeout;
			$types[$dashboard->id] = $dashboard->charts;
			$dashboardsName[$dashboard->id] = $dashboard->name;

			if($dashboard->charts == 'pie')
			{
				foreach($data as $records)
				{
					foreach($records as $key => $value)
					{
						$attributes->put($key,$value);
					}
				}
				$charts[$dashboard->id] = new PieChart;
				$charts[$dashboard->id]->labels($attributes->keys())->load($api);
			}
			if($dashboard->charts == 'line')
			{
				$columnName = collect();

				foreach($data[0] as $key => $value)
				{
					if($key === 'Period')
					{
						$chartsLabels = Arr::pluck($data,$key);
					}
					else{
						$chartsValues = Arr::pluck($data,$key);
						$columnName = $key;
					}
					
				}
				
				$charts[$dashboard->id] = new PieChart;
				$charts[$dashboard->id]->options([
					'yAxis'=>[
						'min'=> 10,
					]
				]);

				$charts[$dashboard->id]->label($columnName);
				$charts[$dashboard->id]->labels($chartsLabels)->load($api);

			}
			if($dashboard->charts == 'column')
			{
				$columnName = collect();

				foreach($data[0] as $key => $value)
				{
					if($key === 'Period')
					{
						$chartsLabels = Arr::pluck($data,$key);
					}
					else{
						$chartsValues = Arr::pluck($data,$key);
						$columnName = $key;
					}
					
				}
				$charts[$dashboard->id] = new PieChart;
				$charts[$dashboard->id]->options([
					'plotOptions' => [
						'column' => [
		
							'dataLabels' => [
								'enabled' => true,
								'crop' => false,
								'overflow' => 'none',
							],
						],
					],
					'loading' => [
						'labelStyle' => [
							'top' => '35%',
							'fontSize' => '2em'
						],
					],
				]);
				$charts[$dashboard->id]->label($columnName);
				$charts[$dashboard->id]->labels($chartsLabels)->load($api);
			}
			if($dashboard->charts == 'table')
			{

				if(!Empty($data[0]))
				{	
					$i = 0;
					foreach($data[0] as $key => $value)
					{
						
						$tableColumnName[$dashboard->id][$i] = $key; 
						
						$i++;

					}
				}

			}

		}
		
		if(!isset($tableColumnName))
		{
			$tableColumnName[0][0]=null;
		}
		if(!isset($charts))
		{
			$charts[0]=null;
		}
		return view('ProjectManager.show',compact([
			'charts',
			'timeouts',
			'project',
			'types',
			'tableColumnName',
			'dashboardsName'
		]));
	}
}
