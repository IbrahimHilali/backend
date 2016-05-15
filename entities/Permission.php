<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 * @package Grimm
 *
 * @property int id
 * @property string name
 * @property Role[] roles
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 */
class Permission extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}