<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * @package Grimm
 *
 * @property int id
 * @property string name
 * @property bool has_all_permissions
 * @property Permission[] permissions
 * @property User[] users
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 */
class Role extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'has_all_permissions',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}