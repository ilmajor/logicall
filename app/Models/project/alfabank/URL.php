<?php

namespace App\Models\project\alfabank; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\Task;

class URL extends Model
{

	use Notifiable;
	//protected $connection= 'oktell';
	protected $primaryKey = 'Id';
	protected $fillable = [
		'TaskId',
		'url',
		'idUser',
		'updated_at'
	];

    protected $table = 'oktell.dbo.list_TM_alfabank_url';
    
    public function task()
    {
    	return $this->hasOne(Task::class,'uuid' ,'TaskId');
    }

}
