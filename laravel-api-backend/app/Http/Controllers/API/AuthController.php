<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
        public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'captcha_answer' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Math Captcha Check
        if ($request->captcha_answer != session('captcha_result')) {
            return response()->json(['error' => 'Captcha is incorrect'], 403);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user'
        ]);

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user], 201);
    }

    // Login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json(['token' => $token,
         'user' => [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role 
        ]
    ]);
    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    // Get Logged-in User Info
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}


