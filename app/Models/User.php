<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use LogsActivity;
 
    protected static $logOnlyDirty = true;
    protected static $logFillable = true;
    protected static $logUnguarded = true;
 
    public function getDescriptionForEvent(string $eventName): string
    {
        return "This model has been {$eventName}";
    }

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'login', 'password','id_user',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $table = 'Users';

    public function roles()
    {
      return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function maxWeightRole()
    {
      return $this->belongsToMany(Role::class)
        ->as('subscription')
        ->withTimestamps();
    }

    /**
    * @param string|array $roles
    */
    public function authorizeRoles($roles)
    {
        if ($this->hasAnyRole($roles)) {
            return true;
        }
        abort(401, 'This action is unauthorized.');
    }
    /**
    * Check multiple roles
    * @param array $roles
    */
    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    /**
    * Check one role
    * @param string $role
    */
    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }

    public function profiles()
    {
      return $this->hasOne(Profile::class);
    }
    
    public function projects()
    {
      return $this->belongsToMany(Project::class)->withTimestamps();
    }

    public function hasProject($project)
    {
        if ($this->projects()->where('project_id', $project)->first()) {
            return true;
        }
        return false;
    }

    public function hasAnyProject($projects)
    {
        if (is_array($projects)) {
            foreach ($projects as $project) {
                if ($this->hasProject($project)) {
                    return true;
                }
            }
        } else {
            if ($this->hasProject($projects)) {
                return true;
            }
        }
        return false;
    }

    public function authorizeProjects($projects)
    {
        if ($this->hasAnyProject($projects)) {
            return true;
        }
        abort(401, 'Ограничение по проектам.');
    }

    public function OktellUserControls()
    {
        return $this->belongsToMany(
            OktellUserControl::class,
            'A_Users',
            'id',
            'id',
            'id_user', // переменная для where
            'UserA',
            null,
            null
        );
/*
        public function belongsToMany(
            $related, 
            $table = null,
            $foreignPivotKey = null,
            $relatedPivotKey = null,
            $parentKey = null,
            $relatedKey = null,
            $relation = null
        )
*/
    }

    public function OktellUserUnderControls()
    {
        return $this->belongsToMany(         
            'A_Users',
            'id',
            'id',
            'id_user', // переменная для where
            'UserB',
            null,
            null
        );
    }
/*
    public static function managers()
    {
        return static::whereHas('roles', function ($query) {
                $query->whereIn('roles.name' ,['manager','supervisor']);
            })
            ->orderBy('users.name','asc')
            ->get();
    }*/

/*    public static function admins($roles)
    {
        return static::whereHas('roles', function ($query) use($roles){
                $query->whereIn('roles.name' ,$roles);
            })
            ->orderBy('users.name','asc')
            ->get();
    }*/

/*    public function sections()
    {
      return $this->hasMany(Section::class);
    }*/
}
 