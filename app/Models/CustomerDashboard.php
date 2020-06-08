<?php

namespace App\Models;


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
