<?php

namespace App\Http\Controllers;

use App\Interfaces\UserInterface;
// use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    //
    private $user;
    public function __construct(UserInterface $userInterUserInterface)
    {
        parent::__construct();
        $this->middleware('jwtauth')->except(['login', 'register', 'getDisposableToken', 'useDisposableToken']);
        $this->user = $userInterUserInterface;
    }

    public function register()
    {
        $register = $this->user->register();
        return $register;
    }

    public function login()
    {
        $login = $this->user->login();
        return $login;
    }

    public function logout()
    {
        $logout = $this->user->logout();
        return $logout;
    }

    public function getDisposableToken(Request $request)
    {
        $token = request()->session()->token();

        $token = csrf_token();
        return response()->json(['csrf' => $token], 200);
    }

    public function useDisposableToken($token)
    {
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}