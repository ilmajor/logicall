<?php

namespace App;


class Task extends Model
{
    protected $primaryKey = 'id';

    public function settings()
    {
    	return $this->hasOne(OktellSetting::class,'idtask','uuid');
    }
    public function project()
    {
    	return $this->belongsTo(Project::class)->orderBy('name');
    }
    public function tecos()
    {
    	return $this->hasOne(\App\project\sberbankLE\Tecos::class,'uuid','uuid');
    }
    public function databaseExclusion()
    {
        return $this->hasMany(DatabaseExclusion::class);
    }
}
