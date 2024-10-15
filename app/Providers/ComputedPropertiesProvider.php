<?php

namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Statamic\Facades\Asset;
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

        Collection::computed('private_galleries', 'processed_images', function ($entry, $value) {
            $images = $entry->get('assets');

            if (empty($images)) {
                return null;
            }

            $shouldProcessImages = $entry->get('watermark') || $entry->get('lowres');

            if (! $shouldProcessImages) {
                return $images;
            }

            // TODO: Implement caching.
            /* Save resources by returning the cached processed images if the selection of images hasn't changed. */

            return Asset::query()
                ->where('container', 'private_galleries')
                ->where('folder', str(Arr::first($images))->before('/')->append('/processed'))
                ->whereIn('basename', collect($images)->map(fn ($image) => basename($image))->all())
                ->get()
                ->map(fn ($image) => $image->path())
                ->sortBy(fn ($processed) => collect($images)->search(fn ($original) => basename($processed) === basename($original)))
                ->values()
                ->all();
        });
    }
}
