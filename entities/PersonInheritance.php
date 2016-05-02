<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string entry
 */
class PersonInheritance extends Model {

    use BelongsToPerson;
    use SoftDeletes;

    protected $table = 'person_inheritances';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
