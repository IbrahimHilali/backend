<?php

namespace App\Filters\Shared;

use App\Filters\Filter;
use App\Filters\FlagFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class TrashFilter implements Filter, FlagFilter
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
        return 'trash';
    }

    public function apply(Builder $query, Collection $values)
    {
        if ($values->has('trash')) {
            $key = $this->sessionKey();

            $to = $values->get($this->appliesTo());
            session([$key => $to]);
        }
        return $query;
    }

    public function default(Builder $query)
    {
        if (session($this->sessionKey())) {
            $query->withTrashed();
        }
    }

    protected function sessionKey()
    {
        return $this->namespace . '.trash';
    }

    public function shouldPreserve()
    {
        return false;
    }

    public function nextValue()
    {
        return !session($this->sessionKey());
    }

    public function applied()
    {
        return session($this->sessionKey());
    }
}
