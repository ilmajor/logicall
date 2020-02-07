<?php

namespace App\Models;

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