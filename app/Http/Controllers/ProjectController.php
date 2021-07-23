<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();

        // compact() creates an array from variables and their values
        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        // works without this line
        // $project = Project::findOrFail(request('project'));

        return view('projects.show', compact('project'));
    }

    public function store()
    {
        // validate
        $attributes = request()->validate([
            'title' => 'required', 
            'description' => 'required'
        ]);

        // presist / save 
        Project::create($attributes);

        // redirect
        return redirect('/projects');
    }
}
