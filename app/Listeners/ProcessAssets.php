<?php

namespace App\Listeners;

use App\Jobs\ProcessAssets as ProcessAssetsJob;
use Statamic\Events\EntrySaved;
use Statamic\Facades\CP\Toast;

class ProcessAssets
{
    public function handle(EntrySaved $event): void
    {
        if (! $this->shouldProcessAssets($event)) {
            return;
        }

        ProcessAssetsJob::dispatch($event->entry);

        Toast::info(__('Assets processing started. This may take a few minutes.'));
    }

    protected function shouldProcessAssets(EntrySaved $event): bool
    {
        if ($event->entry->collectionHandle() !== 'private_galleries') {
            return false;
        }

        if ($event->entry->isClean(['assets', 'watermark', 'lowres'])) {
            return false;
        }

        return true;
    }
}
