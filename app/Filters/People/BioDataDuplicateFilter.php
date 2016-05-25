<?php

namespace App\Filters\People;

use App\Filters\Filter;
use App\Filters\SelectableFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class BioDataDuplicateFilter implements Filter, SelectableFilter
{

    public function appliesTo()
    {
        return 'biodata_extractor';
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
            $query->where('bio_data', \DB::raw("CONCAT(IFNULL(birth_date,''), '-', IFNULL(death_date,''))"));
        }
    }

    public function shouldPreserve()
    {
        return false;
    }

    protected function sessionKey()
    {
        return $this->appliesTo();
    }

    public function displayString()
    {
        return 'filters.biodata_extractor';
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
}
