<?php

namespace App\Modifiers;

use Statamic\Facades\Compare;
use Statamic\Modifiers\Modifier;

class GroupByEvenOdd extends Modifier
{
    /**
     * Modify a value.
     *
     * @param  mixed  $value  The value to be modified
     * @param  array  $params  Any parameters used in the modifier
     * @param  array  $context  Contextual values
     * @return mixed
     */
    public function index($value, $params, $context)
    {
        if (Compare::isQueryBuilder($value)) {
            $value = $value->get()->map->toAugmentedArray();
        }

        return collect($value)
            ->groupBy(fn ($item, $key) => $key % 2 == 0 ? 'even' : 'odd');
    }
}
