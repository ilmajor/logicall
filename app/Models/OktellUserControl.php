<?php

namespace App\Models;

class OktellUserControl extends Model
{

    protected $connection= 'oktell';
    protected $table = 'oktell.dbo.A_UserControls';
    public $timestamps = false;
    
    protected $primaryKey = null;
    public $incrementing = false;

    public function OktellUserControls()
    {
        return $this->belongsToMany(
            Users::class,
            $table,
            'id',
            'id',
            'id_user',
            'UserA',
            null,
            null
        );
    }
}
