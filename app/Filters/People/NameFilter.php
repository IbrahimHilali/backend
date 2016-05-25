<?php

namespace App\Filters\People;

use App\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class NameFilter implements Filter
{

    public function appliesTo()
    {
        return 'name';
    }

    public function apply(Builder $query, Collection $values)
    {
        return $query->searchByName($values->get('name'));
    }

    public function shouldPreserve()
    {
        return true;
    }
}
