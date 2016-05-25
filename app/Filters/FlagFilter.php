<?php

namespace App\Filters;

interface FlagFilter
{
    public function applied();

    public function nextValue();
}
