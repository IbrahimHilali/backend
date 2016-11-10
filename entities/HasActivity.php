<?php

namespace Grimm;

trait HasActivity
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'model');
    }
}
