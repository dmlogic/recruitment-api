<?php

namespace Dmlogic\RecruitmentApi;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

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
        Route::group([
            'prefix'     => 'recruitment',
            'namespace'  => 'Dmlogic\RecruitmentApi\Http\Controllers',
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
        });
    }

    protected function registerBindings()
    {
    }
}
