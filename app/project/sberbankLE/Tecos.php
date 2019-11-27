<?php

namespace App\project\sberbankLE;

//use Illuminate\Database\Eloquent\Model;
use App\Model;
use App\Task;
use App\Project;

class Tecos extends Model
{
	protected $table = 'Tecos';


	//public function 

    public function task()
    {
    	return $this->hasOne(Task::class,'uuid','uuid');
    }
/*    public function project()
    {
    	$tecos = Tecos::with('task.project')->get();
    	foreach($tecos as tasks){
    		dd($tasks);
    	};
    }
*/
}
