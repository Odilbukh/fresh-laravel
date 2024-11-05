<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectCreateRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request){
        $projects = Project::paginate($request->input('perPage', 20));
        return response()->json($projects, 200);
    }

    public function store(ProjectCreateRequest $request){
        $request->validate([
            'name' => 'required|string|max:30'
        ]);

        $project = Project::create([
            'name' => $request->name
        ]);

        if (!$project){
            return response()->json(['message' => 'Project cannot be created']);
        }

        return response()->json(['message' => 'Project created successfully']);

    }
    public function show($id){
        return response()->json(Project::findorFail($id));
    }

    public function update($id, Request $request)
    {
        $project = Project::findOrFail($id);

        $project->update([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Project updated successfully',
            $project
        ]);
    }

    public function destroy($id)
    {
        $project = Task::findOrFail($id);
        $project->delete();

        return response()->json([
            'message' => 'Project was deleted successfully'
        ]);
    }


}
