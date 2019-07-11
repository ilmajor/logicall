<?php

namespace App;

use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class Model extends Eloquent
{
	use LogsActivity;
 
    //protected $fillable = ['name', 'text'];
    protected static $logOnlyDirty = true;
    protected static $logFillable = true;
    protected static $logUnguarded = true;
 
    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }

	protected $guarded = [];
}