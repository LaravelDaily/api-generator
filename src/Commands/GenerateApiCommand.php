<?php

namespace Laraveldaily\Apigenerator\Commands;

use Illuminate\Console\Command;
use Laraveldaily\Apigenerator\Generators\ApiControllerGenerator;
use Laraveldaily\Apigenerator\Generators\ApiRouteGenerator;

class GenerateApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:api {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates api scaffolding';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //check model

        $model = ucfirst($this->option('model'));

        $modelPath = base_path('app/' . $model . '.php');
        if (!file_exists($modelPath)) {
            $this->error('Model not found at ' . $modelPath);
            return null;
        }

        $controller = new ApiControllerGenerator($model);

        //check controller
        if ($controller->exists()) {
            //override?
            if ($this->confirm('Controller exists. Do you wish to override?')) {
                if ($controller->create()) {
                    $this->info('Created API controller.');
                } else {
                    $this->error('Couldn\'t create the controller.');
                }
            }
        } else {
            $controller->create();
            $this->info('Created API controller.');
        }

        $route = new ApiRouteGenerator();
        if (!$route->resource($model)) {
            $route->generate();
            $this->info('Created API route.');
        } else {
            $this->info('API route already exists.');
        }

    }
}
