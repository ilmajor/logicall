<?php

namespace App\Models;


class ContractingOrganization extends Model
{
	protected $table = 'ContractingOrganizations';
	protected $fillable = [
		'director',
		'name',
		'uuid'
	];

}