<?php

namespace Dmlogic\RecruitmentApi;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Dmlogic\RecruitmentApi\Http\Middleware\VerifyApplication;

class RecruitmentApiProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerConfig();
        $this->registerRoutes();
        $this->registerViews();
    }

    protected function registerConfig()
    {
        $this->publishes([
           __DIR__.'/../config/recruitment.php' => config_path('recruitment.php'),
        ]);
    }

    protected function registerViews()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'recruitment');

        $this->publishes([
            __DIR__.'/../views' => resource_path('views/vendor/recruitment'),
        ]);
    }

    protected function registerRoutes()
    {
        $this->app['router']->aliasMiddleware('verify_application', VerifyApplication::class);
        Route::group([
            'prefix'     => config('recruitment.endpoint', 'api'),
            'namespace'  => 'Dmlogic\RecruitmentApi\Http\Controllers',
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
        });
    }
}
