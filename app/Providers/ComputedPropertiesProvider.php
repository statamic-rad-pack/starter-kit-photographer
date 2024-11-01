<?php

namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
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
            return Cache::rememberForever("{$entry->id()}-processed-images", function () use ($entry) {
                $images = $entry->get('assets');

                if (empty($images)) {
                    return null;
                }

                $returnProcessedImages = $entry->get('watermark') || $entry->get('lowres');

                if (! $returnProcessedImages) {
                    return $images;
                }

                $originalImages = collect($images);

                $processedImages = Asset::query()
                    ->where('container', 'private_galleries')
                    ->where('folder', str(Arr::first($images))->before('/')->append('/processed'))
                    ->whereIn('basename', $originalImages->map(fn ($image) => basename($image))->all())
                    ->get()
                    ->map(fn ($image) => $image->path());

                /* Fall back to the unprocessed image if a processed version doesn't exist. Like GIFs that are never processed. */
                return $originalImages
                    ->map(function ($originalImage) use ($processedImages) {
                        $key = $processedImages->search(fn ($processedImage) => basename($processedImage) === basename($originalImage));

                        return is_numeric($key) ? $processedImages->get($key) : $originalImage;
                    })
                    ->all();
            });
        });
    }
}
