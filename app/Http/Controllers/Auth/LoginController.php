<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    // Login user
    public function login(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        $credentials = $request->only('name', 'password');

        // Find user by name or email
        $user = User::where('name', $credentials['name'])
            ->orWhere('email', $credentials['name'])
            ->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Attempt to authenticate the user using their email and password
        try {
            if (!$token = JWTAuth::attempt(['email' => $user->email, 'password' => $credentials['password']])) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Could not create token'], 500);
        }

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 200);
    }
}
