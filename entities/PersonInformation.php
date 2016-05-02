<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property PersonCode code
 * @property string data
 */
class PersonInformation extends Model {

    use BelongsToPerson;
    use SoftDeletes;

    protected $table = 'person_information';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function code()
    {
        return $this->belongsTo(PersonCode::class, 'person_code_id');
    }
}
