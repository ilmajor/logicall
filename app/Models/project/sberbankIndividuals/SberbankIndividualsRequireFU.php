<?php

namespace App\Models\project\sberbankIndividuals;

use App\Models\Model;

class SberbankIndividualsRequireFU extends Model
{
	protected $connection= 'oktell';
 	protected $table = 'oktell.dbo.SberbankIndividualsRequireFU';
    protected $fillable = [
		'dataCall',
		'webId',
		'idClient',
		'product',
		'validity',
		'appStatus',
		'comment',
		'user_id',
		'timestamps',
		'created_at',
	];

}
