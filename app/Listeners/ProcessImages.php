<?php

namespace App\Listeners;

use App\Jobs\ProcessImages as ProcessImagesJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Statamic\Events\EntrySaved;

class ProcessImages implements ShouldQueue
{
    public function handle(EntrySaved $event): void
    {
        if (! $this->shouldProcessImages($event)) {
            return;
        }

        Bus::chain([
            new ProcessImagesJob(
                assets: $event->entry->assets,
                watermark: $event->entry->watermark,
                lowres: $event->entry->lowres,
            ),
            fn () => Cache::forget('processed_images'),
        ])->dispatch();
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
