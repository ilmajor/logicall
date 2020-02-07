<?php

namespace App\Models\project\sberbankLE;

//use Illuminate\Database\Eloquent\Model;
use App\Models\Model;
use App\Models\Task;
use App\Models\Project;

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
