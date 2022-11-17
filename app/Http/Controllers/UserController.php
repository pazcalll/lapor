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
        $this->middleware('jwtauth')->except([
            'index',
            'authPage',
            'login',
            'loginPage',
            'register',
            'registerPage',
            'getDisposableToken',
            'useDisposableToken'
        ]);
        $this->middleware('jwtnoauth')->only([
            'login',
            'loginPage',
            'registerPage',
            'register'
        ]);
        $this->user = $userInterUserInterface;
    }

    public function index()
    {
        return view('pages.index');
    }

    public function authPage()
    {
        return view('pages.auth');
    }

    public function loginPage()
    {
        return view('form.login');
    }

    public function registerPage()
    {
        return view('form.register');
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

    public function getProfile()
    {
        $user = $this->user->getProfile();
        return $user;
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