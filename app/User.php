<?php

namespace App;
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
/*    public function sections()
    {
      return $this->hasMany(Section::class);
    }*/
}
