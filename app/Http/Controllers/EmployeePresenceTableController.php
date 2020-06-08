<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\User;
use App\Models\Role;
use App\Models\EmployeePresenceTable;
use App\Models\EmployeePresenceStatus;
use DataTables;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Str;


class EmployeePresenceTableController extends Controller
{
	public function __construct()
	{

	}
	public function index()
	{
		$user = Auth::user();
		$data = Role::UsersMaxWeight(Auth::id());
		$projects = $user->projects;

		$users = User::join('oktell_settings.dbo.A_Users', function ($join) {
				$join->on('users.id_user', '=', 'A_Users.id');
			})
			->LeftJoin('employee_presence_table', function ($join) {
				$join->on('employee_presence_table.user_id', '=', 'users.id');
			})
			->with('profiles')

			->WhereHas('projects', function ($query) use($projects) {
				$query->whereIn("projects.id", $projects->pluck('id'));
			})
			->WhereHas('roles', function ($query) use($data)  {
				$query->where('roles.weight' ,'<' , User::find(Auth::id())->roles->max('weight'))
					->whereNotIn(
						'role_user.user_id'
						,$data !== null ? $data->users->pluck('id') : [0]
					);
			})
			->where("IsDeleted",0)
			->distinct()
			->selectRaw('
					Users.id
					,sum(case when month(presence_date) = month(getdate()) then work_time end) as work_time 
					,sum(case when  month(presence_date) = month(getdate()) and condition = 2 then 1 else 0 end) as condition2
					,sum(case when  month(presence_date) = month(getdate()) and condition = 1 then 1 else 0 end) as condition1
			')
			->groupBy('Users.id');

		if($user->roles->max('weight') < 90) {
			$users->WhereHas('profiles', function ($query) use($user) {
				$query->where("profiles.City", $user->profiles->City);
			});
		}
		$users = $users->get();
		$users = $users->sortBy('profiles.FullName');
		
		return view('EmployeePresenceTable.index',compact('users','projects'));
	}

	public function show( User $user, Request $request)
	{

		$this->authorize('profileAccess', $user, $user);

		$EmployeePresenceStatus = EmployeePresenceStatus::all();
		$user = $user->profiles()->first();

		if (Carbon::now()->format('d') <= 5 )
		{
			$ReportDate = (new Carbon('first day of last month'))->format('Y-m-d');
		}
		else
		{
			$ReportDate = Carbon::now()->firstOfMonth()->format('Y-m-d');
		}
		
		
		if($request->ajax())
		{
			
			$data = EmployeePresenceTable::query()
				->leftJoin('Employee_presence_status', function ($join) {
					$join->on('employee_presence_table.condition', '=', 'Employee_presence_status.id');
				})
				->select(['user_id','work_time','Employee_presence_status.name as condition','presence_date','employee_presence_table.id','comment'])
				->where('presence_date', '>=', $ReportDate)
				->where('user_id', $user->user_id);
				
			return DataTables::of($data)
				->setRowClass(function ($data) {
					return $data->presence_date->dayOfWeek >= 1 && $data->presence_date->dayOfWeek <= 5 ? 'alert-success' : 'alert-warning';
				})
				->setRowId(function ($data) {
					return $data->id;
				})
				->setRowData([
					'data-id' => function($data) {
						return 'row-' . $data->id;
					},
					'data-name' => function($data) {
						return 'row-' . $data->name;
					},
				])
				->editColumn('presence_date', function($data) {
					return Carbon::parse($data->presence_date)->format('d-m-Y');
				})
				->editColumn('comment', function($data) {
					//return substr($data->comment,0,10);
					return Str::limit($data->comment,10);
				})
				->make(true);
		}


		return view('EmployeePresenceTable.show',compact('user','EmployeePresenceStatus'));
	}

	public function edit($id)
	{
		if(request()->ajax()) {
			$data = EmployeePresenceTable::findOrFail($id);
			return response()->json(['result' => $data]);
		}
	}

	public function update(Request $request, EmployeePresenceTable $EmployeePresenceTable)
	{
/*		$this->validate(request(),[
			'Name' => 'required',
			'code_name' => 'required',
			'code_descript' => 'required',
			'code_name_short' => 'required'

		]);

		if($error->fails()) {
			return response()->json(['errors' => $error->errors()->all()]);
		}*/

		$EmployeePresenceTable = EmployeePresenceTable::find($request->hidden_id)
			->update([
				'work_time' => $request->work_time,
				'condition' => $request->condition,
				'comment' => $request->comment
			]);
		
		$data = EmployeePresenceTable::findOrFail($request->hidden_id);
		return response()->json([
			'success' => 'Данные успешно обновлены',
			'result' => $data

		]);

	}
}
