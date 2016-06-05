<?php

namespace App\Filters\Shared;

use App\Filters\FilterWithOptionals;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class SortFilter implements FilterWithOptionals
{

    protected $unknownFieldCallback;
    protected $orderByKey = '';
    protected $direction = 'asc';

    public function __construct($unknownFieldCallback)
    {
        $this->unknownFieldCallback = $unknownFieldCallback;
    }

    public function appliesTo()
    {
        return 'order-by';
    }

    public function apply(Builder $query, Collection $values)
    {
        $this->orderByKey = $values->get('order-by');
        $this->direction = ($values->get('direction', 0)) ? 'desc' : 'asc';
    }

    public function default(Builder $query)
    {
        if (\Schema::hasColumn($query->getModel()->getTable(), $this->orderByKey)) {
            $query->orderBy($this->orderByKey, $this->direction);
        } else {
            if (is_callable($this->unknownFieldCallback)) {
                //dd($this->direction);
                $return = call_user_func_array($this->unknownFieldCallback, [$query, $this->orderByKey, $this->direction]);
                if (!is_null($return)) {
                    $this->orderByKey = $return;
                }
            }
        }
    }

    public function shouldPreserve()
    {
        return true;
    }

    public function optionals()
    {
        return ['direction'];
    }
}
