<?php

namespace Laraveldaily\Apigenerator\Generators;

class ApiControllerGenerator
{
    protected $template;
    protected $search;
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;

        $variables = [
            '$_MODEL_NAME_LOWER_$'  => lcfirst($name),
            '$_MODEL_NAME_$'        => $name,
            '$_MODEL_NAME_PLURAL_$' => str_plural($name),
        ];

        $this->template = new Template();
        $this->template->stub('api-controller')->variables($variables)->generate();

    }

    public function exists()
    {
        return file_exists(base_path('app/Http/Controllers/Api/' . str_plural($this->name) . 'Controller.php'));
    }

    public function create()
    {
        //check if api path exists
        if (!file_exists(base_path('app/Http/Controllers/Api'))) {
            //if not create
            mkdir(base_path('app/Http/Controllers/Api'), 775);
        }

        file_put_contents(base_path('app/Http/Controllers/Api/' . str_plural($this->name) . 'Controller.php'), $this->template->string);

        if ($this->exists()) {
            return true;
        }
        return false;
    }
}
