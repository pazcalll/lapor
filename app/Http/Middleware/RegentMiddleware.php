<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class RegentMiddleware
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
        $user = JWTAuth::toUser(request()->header('Authorization'));
        // $user = JWTAuth::toUser(request()->bearerToken());
        if ($user['role'] == User::ROLE_REGENT) {
            return $next($request);
        } else {
            return response()->json(['error' => 'unauthorized'], 401);
        }
    }
}
