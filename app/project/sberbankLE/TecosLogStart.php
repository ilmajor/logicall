<?php

namespace App\project\sberbankLE;

//use Illuminate\Database\Eloquent\Model;
use App\Model;

class TecosLogStart extends Model
{
    protected $table = 'oktell.dbo.Tm_legal_entity_base_start_log';
    protected $connection= 'oktell';
    public $timestamps = false;
    protected $primaryKey = 'Id';

    protected $fillable = [
        'ID_CAMPAIGN',
        'insertDateTime',
        'TaskId',
        'iduser',
        'done',
        'base_date',
    ];
}
