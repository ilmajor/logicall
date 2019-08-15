<?php

namespace App\project\sberbankLE;

//use Illuminate\Database\Eloquent\Model;
use App\Model;

class Tecos extends Model
{
	protected $table = 'Tecos';
    public function task()
    {
    	return $this->hasOne(\App\Task::class,'uuid','uuid');
    }
}
