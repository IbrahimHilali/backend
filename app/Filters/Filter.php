<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

interface Filter
{

    public function appliesTo();

    public function apply(Builder $query, Collection $values);

    public function shouldPreserve();
}
