<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
use App\Filters\UserFilter;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserRegister;
use App\Jobs\AttachUserProjectJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request, UserFilter $userFilter)
    {
        $users = User::filter($userFilter)->withCount('tasks')->paginate($request->perPage);


        return response()->json($users, 200);
    }

    public function register(UserRegister $request)
    {
        $valideted = $request->validated();
        $valideted['password'] = Hash::make($valideted['password']);

        $user = User::create($valideted);

        if (!$user) {
            return response()->json(['message' => 'User cannot be created'], 500);
        }

        AttachUserProjectJob::dispatch($user->id)->onQueue('my_queue');
        event(new UserCreated($user));

        return response()->json([
            'message' => 'User created successfully',
            $user
        ]);
    }
    public function store(UserCreateRequest $request)
    {
        $valideted = $request->validated();
        $valideted['password'] = Hash::make($valideted['password']);

        $user = User::create($valideted);

        if (!$user) {
            return response()->json(['message' => 'User cannot be created'], 500);
        }

        AttachUserProjectJob::dispatch($user->id)->onQueue('my_queue');
        event(new UserCreated($user));

        $user->roles()->sync([$valideted['role_id']]);
        return response()->json([
            'message' => 'User created successfully',
            $user
        ]);
    }

    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }

    public function update($id, UpdateUserRequest $request)
    {
        $user = User::findOrFail($id);
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        $user->update($validated);

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
