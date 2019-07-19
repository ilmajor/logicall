<?php

namespace App;


class Task extends Model
{
/*    public function settings()
    {
    	return $this->hasOne(OktellSetting::class,'idtask','task_id');
    }*/
    public function project()
    {
    	return $this->belongsTo(Project::class)->orderBy('name');
    }
}
