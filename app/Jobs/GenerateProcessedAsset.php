<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\File;
use Statamic\Contracts\Assets\Asset;
use Statamic\Facades\Glide;

class GenerateProcessedAsset implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Asset $asset, protected array $glideParams)
    {
        //
    }

    public function handle(): void
    {
        if (! $this->shouldProcessAsset()) {
            return;
        }

        $server = Glide::server([
            'source' => str_replace($this->asset->basename(), '', $this->asset->resolvedPath()),
            'cache' => $cache = storage_path('statamic/glide/tmp'),
            'cache_with_file_extensions' => false,
        ]);

        $source = $cache.'/'.$server->makeImage($this->asset->basename(), $this->glideParams);

        $path = $this->asset->container()
            ->disk()
            ->filesystem()
            ->putFileAs($this->asset->folder().'/processed', new File($source), $this->asset->basename());

        $processedAsset = $this->asset->container()
            ->makeAsset($path)
            ->data($this->asset->data());

        $processedAsset->save();

        app()->runningInConsole()
            ? app('files')->delete($source)
            : dispatch(fn () => app('files')->delete($source))->afterResponse();
    }

    protected function shouldProcessAsset(): bool
    {
        return ! empty($this->glideParams)
            && $this->asset->isImage()
            && $this->asset->extension() !== 'gif';
    }
}
