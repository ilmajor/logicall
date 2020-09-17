<?php

namespace App\Http\Controllers\Project\alfabank;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Task;
use App\Models\User;
use App\Models\project\alfabank\URL;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class UrlController extends Controller
{
    public function __construct()
    {
        #
    }

    public function index()
    {
        $task = Task::where('is_outbound',1)->get();
        $data = URL::whereIn('TaskId',$task->pluck('uuid'))
            ->with('task')
            ->get();
        return view('project.alfabank.index',compact([
            'data'
        ]));
    }

    public function store(URL $URL)
    {
        $this->validate(request(),[
            'url' => 'required'
        ]);

        $URL->setConnection('oktell')
        ->update([
            'url' => request('url'),
            'updated_at' => Carbon::now(),
            'idUser' =>  Auth::user()->id_user
        ]);
        sleep(2);
        return redirect()->back();
    }

}
