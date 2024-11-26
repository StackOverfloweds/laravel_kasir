<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // Cek apakah token ada di header Authorization
            if (!$token = $request->header('Authorization')) {
                return response()->json(['message' => 'Token not provided'], 401);
            }

            // Memverifikasi token
            $user = JWTAuth::setToken($token)->authenticate();

            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            // Menyimpan user yang terautentikasi dalam request
            $request->attributes->add(['user' => $user]);

        } catch (JWTException $e) {
            return response()->json(['message' => 'Token is invalid or expired'], 401);
        }

        return $next($request);
    }
}