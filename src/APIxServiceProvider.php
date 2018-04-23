<?php

namespace AbdulmatinSanni\APIx;

use Illuminate\Support\ServiceProvider;

use AbdulmatinSanni\APIx\Commands\Log\DisplayCommand;
use AbdulmatinSanni\APIx\Commands\Log\ClearCommand;

class APIxServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config' => config_path('/'),
        ]);

        $this->loadViewsFrom(__DIR__.'/resources/views', 'api-x');

        if ($this->app->runningInConsole()) {
            $this->commands([
                DisplayCommand::class,
                ClearCommand::class,
            ]);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/api-x.php', 'api-x'
        );

        $this->app->bind('api-x', function () {
            return new APIx;
        });
    }
}
