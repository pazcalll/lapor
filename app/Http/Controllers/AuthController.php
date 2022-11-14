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
        $this->middleware('jwtauth')->except(['login', 'register', 'getDisposableToken', 'useDisposableToken']);
        $this->middleware('web')->only('getDisposableToken');
    }

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