<?php

namespace App\Models\project\sberbankLE;

use App\Models\Model;

class TecosLogStop extends Model
{
    protected $table = 'oktell.dbo.Tm_legal_entity_base_stop_log';
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
