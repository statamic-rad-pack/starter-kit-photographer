<?php

namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Statamic\Assets\Asset;
use Statamic\Facades\Asset as AssetFacade;
use Statamic\Facades\Collection;

class ComputedPropertiesProvider extends ServiceProvider
{
    public function boot(): void
    {
        Collection::computed('galleries', 'preview_image', function ($entry, $value) {
            return $value ?? Arr::first($entry->get('images'));
        });

        Collection::computed('private_galleries', 'preview_image', function ($entry, $value) {
            return $value ?? Arr::first($entry->get('assets'));
        });

        Collection::computed('private_galleries', 'protect', function ($entry, $value) {
            return $entry->password ? 'password' : null;
        });

        Collection::computed('private_galleries', 'processing_enabled', function ($entry, $value) {
            return ($entry->watermark || $entry->lowres) ?? false;
        });

        /* Assets don't support computed properties, so we use the augmented hook as a workaround to attach a processed asset to the original. */
        Asset::hook('augmented', function ($augmented, $next) {
            /* Only private galleries support processed assets. */
            if ($this->containerId() !== 'private_galleries') {
                return $next($augmented);
            }

            /* Ensure we don't attach a processed asset to itself. */
            if (Str::contains($this->folder(), '/processed')) {
                return $next($augmented);
            }

            /* No need to add the property to unprocessable asset types. */
            if (! $this->isImage() || $this->extension() === 'gif') {
                return $next($augmented);
            }

            /* Get the processed version of the asset. */
            $processedAsset = AssetFacade::query()
                ->processed(['basename' => $this->basename()])
                ->first();

            $this->set('processed', $processedAsset);

            return $next($augmented);
        });
    }
}
