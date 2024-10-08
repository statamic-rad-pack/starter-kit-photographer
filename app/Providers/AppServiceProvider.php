<?php

namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Statamic\Facades\Collection;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Collection::computed('galleries', 'preview_image', function ($entry, $value) {
            return $value ?? Arr::first($entry->get('images'));
        });

        Collection::computed('private_galleries', 'protect', function ($entry, $value) {
            return $entry->password ? 'password' : null;
        });
    }
}
