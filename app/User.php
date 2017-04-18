<?php

namespace App;

use App\Models\Application;
use App\Models\Role;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject, CanResetPasswordContract
{
    use Authenticatable, Authorizable, SoftDeletes, CanResetPassword, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    protected $dates = ['deleted_at', 'last_login', 'activated_at'];

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function getFirstNameAttribute()
    {
        if($this->attributes['name'] === null) {
            return '';
        }
        return explode($this->attributes['name'], ' ')[0];
    }


    public function applications() {
        return $this->hasMany(Application::class);
    }

    public function isStaff() {
        return $this->role->name === 'staff';
    }
    public function isAdmin() {
        return $this->role->name === 'admin';
    }
    public function isStudent() {
        return $this->role->name === 'student';
    }



    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
