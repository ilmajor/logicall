<?php

namespace App\Models;


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
    public function CompletionCodes()
    {
        return $this->hasMany(CompletionCode::class,'taskid','uuid')->orderBy('Result');
    }

    public static function availableOutbound($id)
    {
        return static::with('project')
            ->where(function ($query) use($id) {
                $query->whereIn('project_id',User::find($id)->projects->pluck('id'))
                ->orWhereNull('project_id');
            })
            ->whereNotNUll('is_outbound')
            ->get();
    }
}
