<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('jwtauth')->except('login');
    }

    public function login()
    {
        dd(request()->post());
    }
}