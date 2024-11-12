<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use GuzzleHttp\Psr7\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = Role::paginate($request->input('perPage', 20));
        return response()->json($roles,200);
    }
    public function store(StoreRoleRequest $request){
        $validated = $request->validated();
        $role = Role::create($validated);
        $role->users()->attach($request->user_ids);
        if(!$role){
            return response()->json(['message' => 'Role not created'], 500);
        }
        return response()->json(['message' => 'Role created'], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json(Role::findorFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $role = Role::findorFail($id);
        $role->update([
            'name' => $request->name
        ]);

        $role->users()->sync($request->user_ids);

        return response()->json([
            'message' => 'Role updated successfully',
            $role
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $project = Role::findOrFail($id);
        $project->delete();

        return response()->json([
            'message' => 'Role was deleted successfully'
        ]);
    }
}
