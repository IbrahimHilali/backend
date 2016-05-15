<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string entry
 * @property float year
 */
class PersonPrint extends Model {

    use BelongsToPerson;
    use SoftDeletes;

    protected $table = 'person_prints';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
