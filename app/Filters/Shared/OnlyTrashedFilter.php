<?php

namespace App\Filters\Shared;

use App\Filters\Filter;
use App\Filters\SelectableFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * Filter to only display trashed records,
 * whereas TrashFilter does add the trashed records to the
 * result set
 *
 * @package App\Filters\Shared
 */
class OnlyTrashedFilter implements Filter, SelectableFilter
{

    /**
     * @var
     */
    private $namespace;

    public function __construct($namespace)
    {
        $this->namespace = $namespace;
    }

    public function appliesTo()
    {
        return 'only_trashed';
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

    public function shouldPreserve()
    {
        return false;
    }

    public function applied()
    {
        return session($this->sessionKey());
    }

    public function nextValue()
    {
        $key = $this->sessionKey();

        return !session($key);
    }

    public function displayString()
    {
        return 'filters.only_trashed';
    }

    public function default(Builder $query)
    {
        if (session($this->sessionKey())) {
            $query->onlyTrashed();
        }
    }

    private function sessionKey()
    {
        return $this->namespace . '.' . $this->appliesTo();
    }
}
