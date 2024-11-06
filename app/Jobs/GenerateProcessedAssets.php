<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Collection;
use Statamic\Contracts\Assets\Asset;
use Statamic\Facades\GlobalSet;

class GenerateProcessedAssets implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected Collection $assets,
        protected bool $lowres = false,
        protected bool $watermark = false,
    ) {
        //
    }

    public function handle(): void
    {
        $this->assets->each(fn (Asset $asset) => GenerateProcessedAsset::dispatch($asset, $this->glideParams()));
    }

    protected function glideParams(): array
    {
        $settings = GlobalSet::find('settings')->inDefaultSite();

        return collect()
            ->when($this->lowres, fn ($params) => $params->merge([
                'w' => $settings->lowres,
            ]))
            ->when($this->watermark, fn ($params) => $params->merge([
                'mark' => $settings->watermark->mark?->url,
                'markw' => $settings->watermark->markw.'w',
                'markpos' => $settings->watermark->markpos->value(),
                'markpad' => $settings->watermark->markpad.'w',
            ]))
            ->all();
    }
}
