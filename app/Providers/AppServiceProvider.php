<?php

namespace App\Providers;

use App\Http\Resources\PersonResourceCollectionContract;
use App\Http\Resources\PersonResourceContract;
use App\Http\Resources\v1\PersonResourceCollection;
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

        $this->app->bind(PersonResourceCollectionContract::class, function ($app, $data) {
            return new PersonResourceCollection(reset($data));
        });

        $this->app->bind(PersonResourceContract::class, function ($app, $data) {
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
