<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class CollectionMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
      Collection::make(glob(app_path().'/CollectionMacros/*.php'))
        ->mapWithKeys(function ($path) {
            return [$path => pathinfo($path, PATHINFO_FILENAME)];
        })
        ->reject(function ($macro) {
            return Collection::hasMacro($macro);
        })
        ->each(function ($macro, $path) {
            $class = 'App\\CollectionMacros\\'.$macro;
            Collection::macro(Str::camel($macro), app($class)->init());
        });
    }
}
