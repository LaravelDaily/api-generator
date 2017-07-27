# API Generator for Laravel 5

Package to create API Controller and Route entry with one `Artisan` command.

For now we're starting with only one simple command and will expand functionality as needed. Please submit your suggestions in `Issues` section.

# Usage

Run `php artisan make:api --model=XXXXX` where XXXXX is your model name. Model should exist already, our package won't create it. 

This command will generate API Controller and new entry in `routes/api.php` file.

__Example__

`php artisan make:api --model=Project`

Will generate this:

```
<?php

namespace App\Http\Controllers\Api;

use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectsController extends Controller
{
    public function index()
    {
        return Project::all();
    }

    public function store(Request $request)
    {
        $project = Project::create($request->all());

        return $project;
    }

    public function show($id)
    {
        return Project::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->all());

        return $project;
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return '';
    }
}

```

And this line will be added to `routes/api.php`:

```
Route::resource('projects', 'ProjectsController', ['except' => ['create', 'edit']]);
```