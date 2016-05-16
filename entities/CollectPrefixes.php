<?php

namespace Grimm;

use InvalidArgumentException;

trait CollectPrefixes
{
    public static function prefixesOfLength($column, $length=2)
    {
        $instance = new static;
        if (is_array($instance->prefixable) && in_array($column, $instance->prefixable)) {
            return $instance->query()->toBase()->selectRaw('DISTINCT(SUBSTRING('.$column.', 1, ?)) as prefix', [$length])->orderBy('prefix');
        }

        throw new InvalidArgumentException('Column is not in prefixable array!');
    }
}
