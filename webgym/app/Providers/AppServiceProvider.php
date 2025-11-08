<?php

namespace App\Providers;

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
    public function boot()
    {
        // Ép load CLOUDINARY_URL nếu có
        if ($url = env('CLOUDINARY_URL')) {
            config(['cloudinary.cloud_url' => $url]);
        }

        // Hoặc ép từ 3 biến
        if (env('CLOUDINARY_KEY') && env('CLOUDINARY_SECRET') && env('CLOUDINARY_CLOUD_NAME')) {
            $url = 'cloudinary://' . env('CLOUDINARY_KEY') . ':' . env('CLOUDINARY_SECRET') . '@' . env('CLOUDINARY_CLOUD_NAME');
            config(['cloudinary.cloud_url' => $url]);
        }

        if ($preset = env('CLOUDINARY_UPLOAD_PRESET')) {
            config(['cloudinary.upload_preset' => $preset]);
        }
    }
}

