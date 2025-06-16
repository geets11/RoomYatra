<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use App\Models\PropertyImage;
use Illuminate\Support\Facades\View;

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
        // Force HTTPS in production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        
        // Share storage path with all views
        View::share('storagePath', Storage::url(''));
        
        // Register a custom image URL accessor for PropertyImage model
        PropertyImage::resolveRelationUsing('url', function ($propertyImage) {
            return $propertyImage->getImageUrl();
        });
    }
}
