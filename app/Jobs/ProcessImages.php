<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\File;
use Illuminate\Support\Collection;
use Statamic\Contracts\Assets\Asset;
use Statamic\Facades\Glide;
use Statamic\Facades\GlobalSet;
use Statamic\Globals\Variables;

class ProcessImages implements ShouldQueue
{
    use Queueable;

    protected Variables $settings;

    public function __construct(
        protected Collection $assets,
        protected bool $lowres = false,
        protected bool $watermark = false,
    ) {
        $this->settings = GlobalSet::find('settings')->inDefaultSite();
    }

    public function handle(): void
    {
        if (! $this->shouldProcessImages()) {
            return;
        }

        $this->assets
            ->filter(fn (Asset $asset) => $asset->extensionIsOneOf(['jpg', 'jpeg', 'png', 'webp']))
            ->each($this->processAsset(...));
    }

    protected function processAsset(Asset $asset): void
    {
        $server = Glide::server([
            'source' => str_replace($asset->basename(), '', $asset->resolvedPath()),
            'cache' => $cache = storage_path('statamic/glide/tmp'),
            'cache_with_file_extensions' => false,
        ]);

        $source = $cache.'/'.$server->makeImage($asset->basename(), $this->glideParams()->all());

        $path = $asset->container()
            ->disk()
            ->filesystem()
            ->putFileAs($asset->folder().'/processed', new File($source), $asset->basename());

        $processedAsset = $asset->container()
            ->makeAsset($path)
            ->data($asset->data());

        $processedAsset->save();

        Glide::clearAsset($processedAsset);

        app()->runningInConsole()
            ? app('files')->delete($source)
            : dispatch(fn () => app('files')->delete($source))->afterResponse();
    }

    protected function glideParams(): Collection
    {
        return collect()
            ->when($this->lowres, fn ($params) => $params->merge([
                'w' => $this->settings->lowres,
            ]))
            ->when($this->watermark, fn ($params) => $params->merge([
                'mark' => $this->settings->watermark->mark?->url,
                'markw' => $this->settings->watermark->markw.'w',
                'markpos' => $this->settings->watermark->markpos->value(),
                'markpad' => $this->settings->watermark->markpad.'w',
            ]));
    }

    protected function shouldProcessImages(): bool
    {
        if ($this->assets->isEmpty()) {
            return false;
        }

        if ($this->glideParams()->isEmpty()) {
            return false;
        }

        return true;
    }
}
