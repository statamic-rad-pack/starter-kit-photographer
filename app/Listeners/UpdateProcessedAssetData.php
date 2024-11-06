<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;
use Statamic\Events\AssetSaved;
use Statamic\Facades\Asset;

class UpdateProcessedAssetData implements ShouldQueue
{
    public function handle(AssetSaved $event): void
    {
        if (! $this->shouldProcessAssets($event)) {
            return;
        }

        Asset::query()
            ->processed(['basename' => $event->asset->basename()])
            ->first()
            ?->data($event->asset->data())
            ->saveQuietly();
    }

    protected function shouldProcessAssets(AssetSaved $event): bool
    {
        if ($event->asset->container()->handle() !== 'private_galleries') {
            return false;
        }

        if (Str::endsWith($event->asset->folder(), '/processed')) {
            return false;
        }

        return true;
    }
}
