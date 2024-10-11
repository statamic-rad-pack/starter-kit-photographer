<?php

namespace App\Listeners;

use Statamic\Events\EntrySaved;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\ProcessImages as ProcessImagesJob;

class ProcessImages implements ShouldQueue
{
    public function handle(EntrySaved $event): void
    {
        if (! $this->shouldProcessImages($event)) {
            return;
        }

        ProcessImagesJob::dispatch(
            assets: $event->entry->assets,
            watermark: $event->entry->watermark,
            lowres: $event->entry->lowres,
        );
    }

    protected function shouldProcessImages(EntrySaved $event): bool
    {
        if ($event->entry->collectionHandle() !== 'private_galleries') {
            return false;
        }

        if ($event->entry->isClean('assets') && $event->entry->isClean('watermark') && $event->entry->isClean('lowres')) {
            return false;
        }

        return true;
    }
}
