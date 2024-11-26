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
        // Mengambil kredensial yang dikirimkan dari request
        $credentials = $request->only('name', 'password');

        // Mencari pengguna berdasarkan nama
        $user = User::where('name', $credentials['name'])->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Cek kredensial pengguna
        try {
            if (!$token = JWTAuth::attempt(['email' => $user->email, 'password' => $credentials['password']])) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Could not create token'], 500);
        }

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }
}