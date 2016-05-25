<?php

namespace App\Http\Controllers;

use App\Filters\FilterApplicator;
use Illuminate\Database\Eloquent\Builder;

trait FiltersEntity
{

    protected $filter;

    public function filter(Builder $builder)
    {
        $this->filter = app(FilterApplicator::class);

        if (method_exists($this, 'filters')) {
            $filters = $this->filters();

            $this->filter->registerFilters($filters);
        }

        view()->composer('*', function ($view) {
            $view->with(['filter' => $this->filter]);
        });
        
        return $this->filter->filter($builder, request());
    }
}
