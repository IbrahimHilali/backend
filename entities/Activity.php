<?php

namespace Grimm;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Activity
 * @package App
 *
 * @property integer id
 * @property integer model_id
 * @property string model_type
 * @property array log
 * @property integer user_id
 * @property \Carbon\Carbon created_at
 * @property \Carbon\Carbon updated_at
 * @property User user
 * @property \Illuminate\Database\Eloquent\Model model
 */
class Activity extends Model
{

    protected $table = 'activity';

    protected $fillable = [
        'model_id',
        'model_type',
        'log',
        'user_id'
    ];

    protected $casts = ['log' => 'array'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getType($pluralize = true)
    {
        $type = strtolower(last(explode('\\', $this->model_type)));

        if ($pluralize) {
            return str_plural($type);
        }

        return $type;
    }
}
