<?php

namespace App\Providers;

use App\Scopes\ProcessedAsset;
use Illuminate\Support\ServiceProvider;
use Statamic\Assets\Asset;

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
        Asset::allowQueryScope(ProcessedAsset::class, 'processed');
    }
}
