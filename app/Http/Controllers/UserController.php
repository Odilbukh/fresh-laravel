<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::withCount('tasks')->paginate($request->perPage);

        return response()->json($users, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'middle_name' =>'string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4|max:8',
            'birthday' => 'date|date_format:Y-m-d|nullable',
            'avatar' => 'nullable',
            'phone' => 'nullable|max:15'
        ]);

        $user = User::create([
            'name' => $request->name,
            'middle_name' => $request->middle_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birthday' => $request->birthday,
            'avatar' => $request->avatar,
            'phone' => $request->phone
        ]);

        if (!$user) {
            return response()->json(['message' => 'User cannot be created'], 500);
        }

        return response()->json([
            'message' => 'User created successfully',
            $user
        ]);
    }

    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }

    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'middle_name' => $request->middle_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birthday' => $request->birthday,
            'avatar' => $request->avatar,
            'phone' => $request->phone
        ]);

        return response()->json([
            'message' => 'User updated successfully',
            $user
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
           'message' => 'User was deleted successfully'
        ]);
    }


}
