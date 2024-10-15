<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;
use Statamic\Events\AssetSaved;

class UpdateProcessedImageData implements ShouldQueue
{
    public function handle(AssetSaved $event): void
    {
        if ($event->asset->container()->handle() !== 'private_galleries') {
            return;
        }

        if (Str::endsWith($event->asset->folder(), '/processed')) {
            return;
        }

        $event->asset->container()
            ->queryAssets()
            ->where('folder', $event->asset->folder().'/processed')
            ->where('basename', $event->asset->basename())
            ->first()
            ?->merge($event->asset->data())
            ->save();
    }
}
