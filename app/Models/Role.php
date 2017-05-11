<?php

namespace App\Models;

use App\User;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Role
 *
 * @package \App
 */
class Role extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    public $timestamps = false;

    protected $cascadeDeletes = ['users'];

    protected $dates = ['deleted_at'];

    public function users() {
        return $this->belongsToMany(User::class);
    }

    /**
     * Permissions are presented as serialized JSON so we have to unserialize it / convert it to JSON.
     * @return mixed
     */
//    public function getPermissionsAttribute() {
//        return unserialize($this->permissions);
//    }

    public function setPermissionsAttribute($permissions) {
        $this->attributes['permissions'] = $permissions;
    }

    public function scopeStudent($query) {
        return $query->where('name', 'student');
    }
}
