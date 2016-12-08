<?php

namespace App\Filters\Library;

use App\Filters\Filter;

class TitleFilter implements Filter
{

    public function appliesTo()
    {
        return 'title';
    }

    public function apply(\Illuminate\Database\Eloquent\Builder $query, \Illuminate\Support\Collection $values)
    {
        return $query->searchByTitle($values->get('title'));
    }

    public function shouldPreserve()
    {
        return true;
    }
}