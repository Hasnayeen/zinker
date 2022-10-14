<?php

namespace App\Http\Controllers;

use App\Models\Project;

class HomeController extends Controller
{
    public function __invoke()
    {
        $projects = Project::all();

        return view('home', [
            'projects' => $projects,
            'currentProject' => $projects->where('default', true)->first(),
        ]);
    }
}
