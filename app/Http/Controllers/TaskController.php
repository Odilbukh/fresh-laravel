<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::paginate($request->perPage);

        return response()->json($tasks, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:30',
            'comments' => 'required|string|max:500',
            'planned_at' => 'required|date',
            'user_id' => 'required|integer'
        ]);

        $task = Task::create([
            'name' => $request->name,
            'comments' => $request->comments,
            'planned_at' => $request->planned_at,
            'user_id' => $request->user_id
        ]);

        if (!$task) {
            return response()->json(['message' => 'Task cannot be created'], 500);
        }

        return response()->json([
            'message' => 'Task created successfully',
            $task
        ]);
    }
    public function show($id)
    {
        return response()->json(Task::findOrFail($id));
    }

public function update($id, Request $request)
{
    $task = Task::findOrFail($id);

    $task->update([
        'name' => $request->name,
        'comments' => $request->comments,
        'planned_at' => $request->planned_at
    ]);

    return response()->json([
        'message' => 'Task updated successfully',
        $task
    ]);
}

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json([
            'message' => 'Task was deleted successfully'
        ]);
    }
}
