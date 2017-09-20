<?php

namespace App\Filters\Library;

use App\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class FolkFilter implements Filter
{

    public function appliesTo()
    {
        return 'folk';
    }

    public function apply(Builder $query, Collection $values)
    {
        // TODO: Implement apply() method.
    }

    public function shouldPreserve()
    {
        // TODO: Implement shouldPreserve() method.
    }
}