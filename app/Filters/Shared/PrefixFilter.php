<?php

namespace App\Filters\Shared;

use App\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PrefixFilter implements Filter
{

    protected $field;

    public function __construct($field)
    {
        $this->field = $field;
    }

    public function appliesTo()
    {
        return 'prefix';
    }

    public function apply(Builder $query, Collection $values)
    {
        return $query->byPrefix($values->get('prefix'), $this->field);
    }

    public function shouldPreserve()
    {
        return true;
    }
}
