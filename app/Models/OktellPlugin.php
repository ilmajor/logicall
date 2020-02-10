<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OktellPlugin extends Model
{
	protected $table = 'oktell_settings.dbo.A_PluginMenu_User';
	protected $connection= 'oktell';
	public $timestamps = false;
	protected $primaryKey = null;
	public $incrementing = false;
	protected $fillable = [
		'IdMenuLink',
		'IdUser',
		'Visible'
	];
}
