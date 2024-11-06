<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Bus;
use Statamic\Contracts\Entries\Entry;

class ProcessAssets implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Entry $entry)
    {
        //
    }

    public function handle(): void
    {
        /**
         * We are deleting previously processed assets so that the Gallery Livewire component
         * won't keep serving old processed assets during the processing of new ones.
         * Deleting previously processed assets also ensures that the Glide cache will be cleared.
         */
        Bus::chain([
            new DeleteProcessedAssets(
                assets: $this->entry->assets
            ),
            new GenerateProcessedAssets(
                assets: $this->entry->assets,
                watermark: $this->entry->watermark,
                lowres: $this->entry->lowres,
            ),
        ])->dispatch();
    }
}
