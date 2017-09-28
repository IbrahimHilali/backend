<?php

namespace App\Filters\Shared;

use App\Filters\Filter;
use App\Filters\SelectableFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class DuplicateEntryFilter implements Filter, SelectableFilter
{

    /**
     * @var
     */
    protected $namespace;

    /**
     * @var
     */
    protected $field;

    public function __construct($namespace, $field)
    {
        $this->namespace = $namespace;
        $this->field = $field;
    }

    public function appliesTo()
    {
        return 'duplicates';
    }

    public function apply(Builder $query, Collection $values)
    {
        if ($values->has($this->appliesTo())) {
            $key = $this->sessionKey();

            $to = $values->get($this->appliesTo());
            session([$key => $to]);
        }

        return $query;
    }

    public function default(Builder $query)
    {
        if (session($this->sessionKey())) {
            $query->whereIn('id', function ( $query ) {
                $query->select('id')->from($this->namespace)->where('deleted_at', null)->groupBy($this->field)->havingRaw('count(*) > 1');
            });
        }
    }

    public function shouldPreserve()
    {
        return false;
    }

    protected function sessionKey()
    {
        return $this->namespace . '.duplicate.' . $this->field;
    }

    public function applied()
    {
        return session($this->sessionKey());
    }

    public function nextValue()
    {
        return !session($this->sessionKey());
    }

    public function displayString()
    {
        return 'filters.duplicate_entry';
    }
}