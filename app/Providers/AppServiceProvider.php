<?php

namespace App\Providers;

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

        $this->app->bind('PersonResourceCollection', function ($app, $data) {
            return \App\Http\Resources\v1\PersonResource::collection(reset($data));
        });

        $this->app->bind('PersonResource', function ($app, $data) {
            //check which API version we are
            switch (request()->route()->getPrefix()){
                case 'api/v1/':
                    return new \App\Http\Resources\v1\PersonResource(reset($data));

                case 'api/v2/':
                    return new \App\Http\Resources\v2\PersonResource(reset($data));
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
