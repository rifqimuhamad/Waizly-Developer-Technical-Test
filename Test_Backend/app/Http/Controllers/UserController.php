<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        Log::info('User registered successfully', ['user_id' => $user->id]);
        return response()->json(['success' => true, 'user' => $user, 'token' => $token], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            $user->token = $token;
            $user->save();
            Log::info('User logged in successfully', ['user_id' => $user->id]);
            return response()->json(['success' => true, 'access_token' => $token]);
        }
        Log::warning('User could not log in', ['email' => $request->email]);
        return response()->json(['error' => 'Unathorized'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        Log::info('User logged out successfully', ['user_id' => $request->user()->id]);
        return response()->json(['success' => true, 'message' => 'Logout successful']);
    }
}
