<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerDashboard extends Model
{
	protected $table = 'customer_dashboards';
	protected $fillable = [
		'name',
		'query',
		'charts',
		'project_id',
		'timeout'
	];
}
