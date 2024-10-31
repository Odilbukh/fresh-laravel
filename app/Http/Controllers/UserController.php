<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
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

    public function store(UserCreateRequest $request)
    {
        $valideted = $request->validated();
        $valideted['password'] = Hash::make($valideted['password']);

        $user = User::create($valideted);

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
