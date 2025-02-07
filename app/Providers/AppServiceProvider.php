<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        App::singleton('products', function () {
            $path = storage_path('app/products.json');
            if (file_exists($path)) {
                $fileContent = file_get_contents($path);
                return json_decode($fileContent, true);
            }

            return [];
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
