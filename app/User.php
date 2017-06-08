<?php

namespace App;

use App\Models\Application;
use App\Models\Faculty;
use App\Models\Role;

use CollegeApplication\Authentication\CanConfirmRegistration;
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
    use Authenticatable, Authorizable, SoftDeletes, CanResetPassword, Notifiable, CanConfirmRegistration;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'last_login', 'username', 'faculty_id', 'role_id', 'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    protected $dates = ['deleted_at', 'last_login', 'activated_at', 'activation_email_sent_at', 'activation_expires_at'];


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

    public function faculty() {
        return $this->belongsTo(Faculty::class);
    }

    public function isReferent() {
        return $this->role->name === 'referent';
    }
    public function isAdmin() {
        return $this->role->name === 'admin';
    }
    public function isStudent() {
        return $this->role->name === 'student';
    }
    public function isEnrollmentService() {
        return $this->role->name === 'enrollment_service';
    }

    public function saveToken(string $token)
    {
        $this->api_token = $token;
        $this->save();
    }

    public function scopeStudents($query)
    {
        return $query->where('role_id', Role::student()->first()->id);
    }


    public function activated(): bool
    {
        return $this->activated_at != null;
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
