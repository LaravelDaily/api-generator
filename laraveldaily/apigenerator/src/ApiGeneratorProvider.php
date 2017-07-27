<?php

namespace Laraveldaily\Apigenerator;

use Illuminate\Support\ServiceProvider;
use Laraveldaily\Apigenerator\Commands\GenerateApiCommand;

class ApiGeneratorProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateApiCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
