<?php

namespace App\Http\Controllers\Admin;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
Use Illuminate\Support\Facades\Auth;
use App\Section;
use App\Role;

class SectionController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('AuthAdmin');
  }

  public function index()
  {

    $sections = Section::with('role')->get();
    return view('admin.section.index',compact([
      'sections'
    ]));
  }

  public function show($id)
  {
    $roles = Role::get();

    $projects = DB::connection('sqlsrv_srn')
      ->table('oktell_settings.dbo.A_TaskManager_Projects')
      ->orderBy('name','asc')
      ->get();

    $section = Section::with('role')
      ->where('id', $id)
      ->first();
    
    return view('admin.section.show',compact([
    	'section'
      ,'roles'
      ,'projects'
    ]));
  }

  public function create()
  {
    $projects = DB::connection('sqlsrv_srn')
      ->table('oktell_settings.dbo.A_TaskManager_Projects')
      ->orderBy('name','asc')
      ->get();

    $roles = Role::get();

    return view('admin.section.create',compact([
      'projects'
      ,'roles'
    ]));
  }

  public function store(){

    $this->validate(request(),[
      'title' => 'required|min:3',
      'description' => 'required',
      'url' => 'required|min:3',
      'role_id' => 'required',
      //'project' => 'required',
    ]);

    Section::create([
      'title' => request('title'),
      'description' => request('description'),
      'user_id' => Auth::user()->id,
      'url' => request('url'),
      'role_id' => request('role_id'),
      'project' => request('project'),
    ]);

    return redirect()->back();
  }

  public function update($id){
    $this->validate(request(),[
      'title' => 'required|min:3',
      'description' => 'required',
      'url' => 'required|min:3',
      'role_id' => 'required'
    ]);
    
    $Section = Section::where('id', $id)->first();
    $Section->update(request()->except(['_method','_token']));
    
    $Section->save();
    return redirect()->route('sections');
  }
  
  public function destroy($id){
    Section::find($id)->delete();
    return redirect()->back();
  }
}
