<?php

namespace App\Providers;

use App\ReCaptcha;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
        // Adding recaptcha validator to boot phase so it is available globally in the app
        // Also adding new validator (recaptcha) that will be available like built in rules (required, min, max)
        Validator::extend('recaptcha', function ($attribute, $value, $parameters, $validator) {
            // Laravel service container resolving the ReCaptcha class
            return app(ReCaptcha::class)->validateRequest($value);
        });
    }
}
