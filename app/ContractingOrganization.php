<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractingOrganization extends Model
{
	protected $table = 'ContractingOrganizations';
	protected $fillable = [
		'director',
		'name',
		'uuid'
	];

}