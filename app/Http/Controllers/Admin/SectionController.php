<?php

namespace App\Http\Controllers\Admin;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
Use Illuminate\Support\Facades\Auth;
use App\Models\Section;
use App\Models\Role;
use App\Models\Project;
use App\Models\User;

class SectionController extends Controller
{
  public function __construct()
  {
    #$this->middleware('auth');
    #$this->middleware('AuthAdmin');
  }

  public function index()
  {

    $sections = Section::with('role')->get();
    
    return view('admin.section.index',compact([
      'sections'
    ]));
  }

  public function show(Section $section)
  {

    $roles = Role::get();

    $projects = Project::orderBy('name')->get();

    $section = $section->with(['role','projects'])
      ->where('id',$section->id)
      ->first();
      
    return view('admin.section.show',compact([
    	'section'
      ,'roles'
      ,'projects'
    ]));
  }

  public function create()
  {
    $projects = Project::orderBy('name')->get();

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
      'role' => 'required',
    ]);

    $section = Section::create([
      'title' => request('title'),
      'description' => request('description'),
      'user_id' => Auth::user()->id,
      'url' => request('url'),
    ]);

    $section->role()->sync(request()->input('role'));
    $section->projects()->sync(request()->input('project'));

    $section->save();
    return redirect()->route('adminSections');
  }

  public function update(Section $section)
  {
    
    $this->validate(request(),[
      'title' => 'required|min:3',
      'description' => 'required',
      'url' => 'required|min:3',
      //'role' => 'required'
    ]);
    //dd(request()->input('role'));
    $section->update(request()->except(['_method','_token','project','role']));
    
    //dd(request()->input('role'));
    $section->role()->sync(request()->input('role'));

    $section->projects()->sync(request()->input('project'));
    //$Section->save();
/*    if (empty(request()->input('role'))) {
        $logRole = $Section->role()->detach();
    } else {
        $logRole = $Section->role()->sync(request()->input('role'));
    }
    if (empty(request()->input('project'))) {
        $logProjects = $Section->projects()->detach();
    } else {
        $logProjects = $Section->projects()->sync(request()->input('project'));
    }*/

    

/*    activity()
        ->performedOn($Section)
        ->causedBy(auth()->user())
        ->withProperties($logProjects)
        ->log(':causer.name changed sites for :subject.title');*/

/*    activity()
        ->performedOn($Section)
        ->causedBy(auth()->user())
        ->withProperties($logRole)
        ->log(':causer.name changed sites for :subject.title');*/

    return redirect()->route('adminSections');
  }
  
  public function destroy(Section $section){
    $section->delete();
    return redirect()->back();
  }
}
