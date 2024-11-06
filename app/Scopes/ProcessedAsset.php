<?php

namespace App\Scopes;

use Statamic\Query\Scopes\Scope;

class ProcessedAsset extends Scope
{
    /**
     * Apply the scope.
     *
     * @param  \Statamic\Query\Builder  $query
     * @param  array  $values
     * @return void
     */
    public function apply($query, $values)
    {
        $query
            ->where('container', 'private_galleries')
            ->where('folder', 'like', '%/processed')
            ->where('basename', $values['basename']);
    }
}
