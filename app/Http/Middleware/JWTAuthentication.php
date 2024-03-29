<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class JWTAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof TokenExpiredException) {
                $newToken = JWTAuth::parseToken()->refresh();
                return response()->json(['success' => 'false', "token_type" => 'bearer', 'token' => $newToken, 'message' => 'Durasi login habis, harap muat ulang halaman', 'status' => 401], 401);
            } elseif ($e instanceof TokenInvalidException) {
                return response()->json(['success' => 'false', 'message' => 'Token Invalid', 'status' => 401], 401);
            } else {
                return response()->json(['success' => 'false', 'message' => 'Token Not Found', 'status' => 401], 401);
            }
        }
        return $next($request);
    }
}