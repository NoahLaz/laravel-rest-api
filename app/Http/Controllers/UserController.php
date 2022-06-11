<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Register new user
    public function register(Request $request)
    {
        $verifiedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $verifiedData['password'] = bcrypt($verifiedData['password']);

        $user = User::create($verifiedData);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    // Login user
    public function login(Request $request)
    {
        $verifiedData = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // Check email and password
        if (!auth()->attempt($verifiedData)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = User::where('email', $verifiedData['email'])->first();

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    // Log out user
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
