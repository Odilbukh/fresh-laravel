<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }


        return $user->createToken('app_token')->plainTextToken;
    }

    public function auth()
    {
        return Auth::user();
    }
    public function logout(Request $request){
        $user = $request->user();
        if($user) {
            return $user->tokens()->delete();
        }
        else {
            return response()->json(['message'=>'You are not authorised'], 401);
        }
    }
}
