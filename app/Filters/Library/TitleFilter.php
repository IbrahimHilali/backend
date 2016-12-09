<?php

namespace App\Filters\Library;

use App\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class TitleFilter implements Filter
{

    public function appliesTo()
    {
        return 'title';
    }

    public function apply(Builder $query, Collection $values)
    {
        return $query->searchByTitle($values->get('title'));
    }

    public function shouldPreserve()
    {
        return true;
    }
}