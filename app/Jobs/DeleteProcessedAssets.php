<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Collection;
use Statamic\Contracts\Assets\Asset;

class DeleteProcessedAssets implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Collection $assets)
    {
        //
    }

    public function handle(): void
    {
        $this->assets->each(fn (Asset $asset) => $asset->processed?->delete());
    }
}
