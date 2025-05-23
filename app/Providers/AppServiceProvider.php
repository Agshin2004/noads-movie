<?php

namespace App\Providers;

use App\Helpers\ReCaptcha;
use Illuminate\Http\Request;
use App\Services\ThirdPartyApiService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;

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
     * boot() - Used to perform actions after all services are registered
     */
    public function boot(): void
    {
        // Adding recaptcha validator to boot phase so it is available globally in the app
        // Also adding new validator (recaptcha) that will be available like built in rules (required, min, max)
        Validator::extend('recaptcha', function ($attribute, $value, $parameters, $validator) {
            // Laravel service container resolving the ReCaptcha class
            return app(ReCaptcha::class)->validateRequest($value);
        });

        // Rate Limiter
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(40)->by($request->user()?->id ?: $request->ip());
        });
    }
}
