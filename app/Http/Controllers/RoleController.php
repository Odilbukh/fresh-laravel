<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = Role::paginate($request->input('perPage', 20));
        return response()->json($roles, 200);
    }

    public function store(StoreRoleRequest $request)
    {
        
        $validated = $request->validated();
        $role = Role::create($validated);

        if (!$role) {
            return response()->json(['message' => 'Role not created'], 500);
        }

        $role->users()->attach($request->user_ids);

        return response()->json(['message' => 'Role created'], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json(Role::findorFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $role = Role::findOrFail($id);

        $role->update([
            'name' => $request->input('name')
        ]);

        $role->users()->sync($request->input('user_ids', []));

        return response()->json([
            'message' => 'Role updated successfully',
            'role' => $role
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json([
            'message' => 'Role was deleted successfully'
        ]);
    }
}
