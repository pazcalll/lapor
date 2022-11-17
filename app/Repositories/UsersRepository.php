<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UsersRepository implements UserInterface
{
    public function register()
    {
        try {
            $validated = request()->validate(
                [
                    'name' => 'required|min:4|max:40|regex:/^[a-zA-Z]+$/u',
                    'username' => 'required|unique:users|max:12|min:4|regex:/^[a-zA-Z]+$/u',
                    'password' => 'required|max:16|min:6',
                    'address' => 'nullable',
                    'role' => 'required|in:admin,officer,customer',
                    'phone' => 'nullable|min:10|max:12'
                ],
                [
                    'username.min' => 'Atribut :attribute minimal 4 karakter',
                    'username.max' => 'Atribut :attribute maksimal 12 karakter',
                    'username.regex' => 'Atribut :attribute hanya boleh buruf dan angka saja',
                    'username.unique' => ':attribute sudah dipakai',
                    'username.required' => 'Atribut :attribute wajib diisi',
                    'password.min' => 'Atribut :attribute minimal 6 karakter',
                    'password.max' => 'Atribut :attribute maksimal 16 karakter',
                    'password.required' => 'Atribut :attribute wajib diisi',
                    'name.min' => 'Atribut :attribute minimal 4 karakter',
                    'name.max' => 'Atribut :attribute maksimal 40 karakter',
                    'name.required' => 'Atribut :attribute wajib diisi',
                    'role.in' => 'Isi tidak sesuai ketentuan',
                    'role.required' => 'Atribut :attribute wajib diisi',
                    'phone.min' => 'Atribut :attribute minimal 10 karakter',
                    'phone.max' => 'Atribut :attribute maksimal 12 karakter',
                ]
            );
            User::create($validated);

            return response()->json(['success' => 'register success', 'status' => 200], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->errors(), 'status' => 400], 400);
            // return response()->json(['error' => $th, 'status' => 400], 400);
        }
    }

    public function login()
    {
        $credentials = request(['username', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function getProfile()
    {
        $user = JWTAuth::toUser(request()->bearerToken());
        return response()->json($user, 200);
    }

    public function updateProfile()
    { }

    public function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);
    }
}