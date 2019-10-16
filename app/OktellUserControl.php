<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Notifications\Notifiable;


class OktellUserControl extends Model
{

    use LogsActivity;
 
    protected static $logOnlyDirty = true;
    protected static $logFillable = true;
    protected static $logUnguarded = true;
 
    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }

    use Notifiable;

	protected $connection= 'oktell';
    protected $table = 'oktell.dbo.A_UserControls';
	public $timestamps = false;

    public function OktellUserControls()
    {
        return $this->belongsToMany(
            Users::class,
            $table,
            'id',
            'id',
            'id_user', // переменная для where
            'UserA',
            null,
            null
        );
    }
}
