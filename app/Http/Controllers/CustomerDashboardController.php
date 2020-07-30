<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use App\Models\CustomerDashboard;
use Carbon\Carbon;
use App\Models\Project;
use App\Models\User;
use App\Charts\PieChart;
use DB;
use Illuminate\Support\Facades\Schema;
use DataTables;

class CustomerDashboardController extends Controller
{
	public function send(CustomerDashboard $CustomerDashboard)
	{

		$borderColors = [
			"rgba(255, 99, 132, 1.0)",
			"rgba(22,160,133, 1.0)",
			"rgba(255, 205, 86, 1.0)",
			"rgba(51,105,232, 1.0)",
			"rgba(244,67,54, 1.0)",
			"rgba(34,198,246, 1.0)",
			"rgba(153, 102, 255, 1.0)",
			"rgba(255, 159, 64, 1.0)",
			"rgba(233,30,99, 1.0)",
			"rgba(205,220,57, 1.0)"
		];

		$fillColors = [
			"rgba(255, 99, 132, 0.2)",
			"rgba(22,160,133, 0.2)",
			"rgba(255, 205, 86, 0.2)",
			"rgba(51,105,232, 0.2)",
			"rgba(244,67,54, 0.2)",
			"rgba(34,198,246, 0.2)",
			"rgba(153, 102, 255, 0.2)",
			"rgba(255, 159, 64, 0.2)",
			"rgba(233,30,99, 0.2)",
			"rgba(205,220,57, 0.2)"
		];

		$data = DB::select($CustomerDashboard->query);
		$attributes = collect();
		if($CustomerDashboard->charts == 'pie')
		{
			foreach($data as $records)
			{
				foreach($records as $key => $value)
				{
					$attributes->put($key,$value);
				}
			}
			$chart = new PieChart;
			$chart->labels($attributes->keys());
			$chart->dataset($CustomerDashboard->name, $CustomerDashboard->charts, $attributes->values())
				->color($borderColors);
			return $chart->api();
		}
		if($CustomerDashboard->charts == 'line')
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
				}
			}
			$chart = new PieChart;
			$chart->dataset($CustomerDashboard->name, $CustomerDashboard->charts, $chartsValues);
			return $chart->api();

		}
		if($CustomerDashboard->charts == 'column')
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
				}
				
			}
			$chart = new PieChart;
			$chart->dataset($CustomerDashboard->name, $CustomerDashboard->charts, $chartsValues);
			return $chart->api();
		}
		if($CustomerDashboard->charts == 'table' )
		{
				if (request()->ajax()) {

					$query = DB::select($CustomerDashboard->query);
					return Datatables($query)->make(true);
				}
		}
	}

	public function show()
	{
		$CustomerDashboards = CustomerDashboard::whereIn('project_id',User::find(Auth::id())
			->projects
			->pluck('id'))
			->get();
			
		$project = Project::find($CustomerDashboards->pluck('project_id'))->pluck('name');
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

		return view('customerDashboard.index',compact([
			'charts',
			'timeouts',
			'project',
			'types',
			'tableColumnName',
			'dashboardsName'
		]));
	}
}