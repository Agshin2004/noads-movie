<?php

namespace App\Providers;

use App\Helpers\ReCaptcha;
use App\Services\ThirdPartyApiService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind ThirdPartApiService in service (IoC container) container
        $this->app->singleton(ThirdPartyApiService::class, function ($app) {
            // laravel will create only one instance and reuse it everywhere
            return new ThirdPartyApiService();
        });        
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
