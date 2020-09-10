<?php

namespace Dmlogic\RecruitmentApi;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Dmlogic\RecruitmentApi\Http\Middleware\VerifyApplication;

class RecruitmentApiProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerRoutes();
        $this->registerViews();
        $this->registerBindings();
    }

    protected function registerViews()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'recruitment');
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

    protected function registerBindings()
    {
    }
}
