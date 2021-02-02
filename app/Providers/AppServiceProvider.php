<?php

namespace App\Providers;

use App\Http\Resources\v1\PersonJSONResponse;
use App\Http\Resources\v1\ResourceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ResourceInterface::class, function($app){
            return new PersonJSONResponse();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
