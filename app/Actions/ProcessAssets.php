<?php

namespace App\Actions;

use App\Jobs\ProcessAssets as ProcessAssetsJob;
use Statamic\Actions\Action;
use Statamic\Contracts\Entries\Entry;
use Statamic\Facades\CP\Toast;

class ProcessAssets extends Action
{
    public function run($entries, $values)
    {
        $entries->each(ProcessAssetsJob::dispatchAfterResponse(...));

        Toast::info(__('Assets processing started. This may take a few minutes.'));
    }

    public function visibleTo($item): bool
    {
        return $item instanceof Entry && $item->collectionHandle() === 'private_galleries';
    }
}
