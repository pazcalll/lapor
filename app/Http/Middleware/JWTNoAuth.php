<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class JWTNoAuth
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
            // dd(JWTAuth::parseToken());
            JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof TokenExpiredException) {
                return response()->json(['success' => 'false', 'message' => 'Token Expired'], 401);
            } elseif ($e instanceof TokenInvalidException) {
                return $next($request);
            } else {
                return $next($request);
            }
        }
        return response()->json(['status' => 401, 'message' => 'You are not guest'], 401);
    }
}