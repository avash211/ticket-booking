<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use App\Http\Middleware\CheckRole;
use App\Services\GenerateQRCodeService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    // public function register(): void
    // {
    //     $this->app->singleton(GenerateQRCodeService::class, function ($app) {
    //         return new GenerateQRCodeService();
    //     });
    // }

    /**
     * Bootstrap any application services.
     */

    public function boot()
    {
        $router = $this->app['router'];
        $router->aliasMiddleware('checkrole', CheckRole::class);

        Schema::defaultStringLength(191);
        Validator::extend('time', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/', $value);
        });
    }



}
