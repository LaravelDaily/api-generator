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

    public function handle()
    {
        $folder = trim($this->ask('Models folder', 'app'), '/');
        $model = ucfirst($this->option('model'));

        if (!file_exists($modelPath = base_path("$folder/$model.php"))) {
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
        if (!$route->resource(str_plural($model))) {
            $route->generate();
            $this->info('Created API route.');
        } else {
            $this->info('API route already exists.');
        }
    }
}
