<?php

namespace App\Repositories;

class UserRepository implements UserInterface
{
    public function register()
    {
        $credentials = request([
            'username',
            'password',
            'name',
            'role',
            'phone',
            'address'
        ]);
        dd($credentials);
    }

    public function login()
    {
        $credentials = request(['username', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}