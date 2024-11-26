<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    // Logout user dan hapus token JWT
    public function logout(Request $request)
    {
        try {
            // Menghapus token dari pengguna yang sedang login
            JWTAuth::invalidate(JWTAuth::getToken());
            
            return response()->json(['message' => 'Successfully logged out'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to log out', 'error' => $e->getMessage()], 500);
        }
    }
}