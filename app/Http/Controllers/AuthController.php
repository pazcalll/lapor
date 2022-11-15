<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //
    public function __construct()
    {
        parent::__construct();
        $this->middleware('jwtauth')->except(['login', 'register', 'getDisposableToken', 'useDisposableToken']);
    }

    public function register(Request $request)
    {
        // $credentials = request([
        //     'username',
        //     'password',
        //     'name',
        //     'role',
        //     'phone',
        //     'address'
        // ]);
        try {
            $validated = $request->validate(
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
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->errors(), 'status' => 400], 400);
        }
        // request()->validate([
        //     'username' => 'required|unique:users|max:12|min:4',
        //     'name' => 'required|max:32|min:4',
        //     'role' => 'required|in:admin,customer,officer',
        //     'password' => 'required|max:16|min:6',
        //     'phone' => 'max:12|min:10',
        //     'address' => 'max:48|min:10',
        // ]);
    }

    public function login()
    {
        $credentials = request(['username', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
        // dd(request()->post());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function getReports(Request $request)
    {
        return dd($request->all());
    }

    public function getProfile()
    {
        $header = request()->bearerToken();
        $token = "";
        if (Str::startsWith($header, 'Bearer ')) {
            $token = Str::substr($header, 7);
        }
        $user = JWTAuth::toUser($token);

        return response()->json(compact('token', 'user'));
    }

    public function getDisposableToken(Request $request)
    {
        $token = $request->session()->token();

        $token = csrf_token();
        return response()->json(['csrf' => $token], 200);
    }

    public function checkDisposableToken()
    {
        if (!empty($_POST['token'])) {
            if (hash_equals($_SESSION['token'], $_POST['token'])) {
                // Proceed to process the form data
                dd('ok');
            } else {
                dd('no');
                // Log this as a warning and keep an eye on these attempts
            }
        }
    }

    public function useDisposableToken($token)
    {
        session_start();
        if (!empty($token)) {
            if (hash_equals($_SESSION['token'], $token)) {
                // Proceed to process the form data
                session_destroy();
                dd('ok');
            } else {
                dd('no');
                // Log this as a warning and keep an eye on these attempts
            }
        }
    }
}