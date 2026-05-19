<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        // Fix Mixed Content: force HTTPS in production (Railway)
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }

        // Auto-create storage symlink if missing (Railway ephemeral filesystem)
        $link = public_path('storage');
        $target = storage_path('app/public');
        if (!file_exists($link) && file_exists($target)) {
            app()->make('files')->link($target, $link);
        }
    }
}
