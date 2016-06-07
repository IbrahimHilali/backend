<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FilterApplicator
{

    /**
     * @var Collection
     */
    protected $requestFilters;
    protected $filters = [];
    protected $defaults = [];
    protected $appliedFilters = [];
    protected $optionalParameters = [];

    /**
     * Register a single new filter.
     *
     * @param Filter $filter
     */
    public function registerFilter(Filter $filter)
    {
        $this->filters[$filter->appliesTo()] = $filter;

        if ($filter instanceof FilterWithOptionals) {
            $this->optionalParameters = array_merge($this->optionalParameters, $filter->optionals());
        }

        if (method_exists($filter, 'default')) {
            $this->defaults[] = $filter;
        }
    }

    /**
     * Register multiple filters at once
     *
     * @param Filter[] $filters
     */
    public function registerFilters(array $filters)
    {
        foreach ($filters as $filter) {
            $this->registerFilter($filter);
        }
    }

    /**
     * Filter a given Builder by the given request data.
     * First the request data is passed to the relevant filters.
     * Afterwards all filters with a default()-method are called.
     *
     * @param Builder $builder
     * @param Request $request
     *
     * @return Builder
     */
    public function filter(Builder $builder, Request $request)
    {

        $this->requestFilters = $this->filterRequest($request);

        foreach ($this->requestFilters as $key => $requestFilter) {
            if (array_key_exists($key, $this->filters)) {
                $this->filters[$key]->apply($builder, $this->requestFilters);
                $this->appliedFilters[] = get_class($this->filters[$key]);
            }
        }

        $this->callDefaults($builder);

        return $builder;
    }

    /**
     * Filter the request variables for relevant fields.
     *
     * @param Request $request
     *
     * @return Collection
     */
    public function filterRequest(Request $request)
    {
        $requestVariables = new Collection($request->all());

        return $requestVariables
            ->filter(function ($value, $key) {
                return array_key_exists($key, $this->filters) || in_array($key, $this->optionalParameters);
            });
    }

    /**
     * Returns true if the given filter has been applied.
     *
     * @param $filter
     *
     * @return bool
     */
    public function applied($filter)
    {
        return in_array($filter, $this->appliedFilters);
    }

    /**
     * Return the filter object for the given filter URL key.
     * 
     * @param $key
     *
     * @return Filter
     */
    public function filterFor($key)
    {
        return $this->filters[$key];
    }

    /**
     * Build the query string for the filters and the given delta
     * (see documentation for the delta method on how to use the
     * $deltaFilters array).
     *
     * @param array $deltaFilters
     *
     * @return string
     */
    public function buildQueryString($deltaFilters = [])
    {
        $delta = $this->delta($deltaFilters);

        return http_build_query($delta);
    }

    /**
     * Collect all filters and their values that should be appended
     * to the URL to another request. The $deltaFilers parameter
     * allows to intercept this list. Adding the name of a filter
     * will toggle the value of this filter as long as it is a FlagFilter.
     * Adding the name of a filter preceded by a dash will remove the filter.
     *
     * @param array $deltaFilters
     *
     * @return array
     */
    public function delta($deltaFilters = [])
    {
        $deltaCollection = collect($deltaFilters);

        /** @var Collection $toRemove */
        $toRemove = $deltaCollection->filter(function ($value, $key) {
            return is_numeric($key) && starts_with($value, '-');
        })->map(function ($item) {
            return substr($item, 1);
        });

        $flags = $this->flags($deltaCollection);

        $additionalFields = $deltaCollection->filter(function ($value, $key) {
            return is_string($key);
        });

        return $delta = $this->requestFilters->filter(function ($value, $key) use ($toRemove) {
            return $this->shouldFilterValueBePreserved($key, $toRemove);
        })->merge($additionalFields)->merge($flags)->toArray();
    }

    /**
     * Grab all filters, that are selectable, i.e. can be switched on or off.
     *
     * @return Collection
     */
    public function selectable()
    {
        $selectable = collect($this->filters)->filter(function ($value) {
            return $value instanceof SelectableFilter;
        });

        return $selectable;
    }

    /**
     * Fetch all currently active selectable filters.
     *
     * @return Collection
     */
    public function selected()
    {
        return $this->selectable()->filter(function ($value) {
            return $value->applied();
        });
    }

    /**
     * Check if there are selectable filters, that are currently selected.
     *
     * @return bool
     */
    public function hasSelected()
    {
        return $this->selected()->count() > 0;
    }

    /**
     * Call the filters that have a default action, i.e. an action
     * that is always set to run.
     *
     * @param Builder $builder
     */
    protected function callDefaults(Builder $builder)
    {
        foreach ($this->defaults as $defaultFilter) {
            $defaultFilter->default($builder);
        }
    }

    /**
     * Filter the given delta collection for flags.
     * These are values with numerical key, that are not
     * preceded by a dash.
     *
     * @param $deltaCollection
     *
     * @return mixed
     */
    protected function flags(Collection $deltaCollection)
    {
        $flags = $deltaCollection->filter(function ($value, $key) {
            return is_numeric($key) && !starts_with($value, '-');
        })->flatMap(function ($value, $key) {
            $filter = $this->filterFor($value);

            return [$value => $filter->nextValue()];
        });

        return $flags;
    }

    /**
     * Determines if the given filter value should be preserved in
     * the URL for the next page.
     *
     * @param string     $key
     * @param Collection $toRemove
     *
     * @return bool
     */
    protected function shouldFilterValueBePreserved($key, $toRemove)
    {
        if (array_key_exists($key, $this->filters)) {
            $filterClass = $this->filters[$key];

            return $filterClass->shouldPreserve() && !$toRemove->contains($key);
        }

        return in_array($key, $this->optionalParameters);
    }
}
