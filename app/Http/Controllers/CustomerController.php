<?php

namespace App\Http\Controllers;

use App\Interfaces\UserInterface;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Customer Repository
    private $user;
    public function __construct(UserInterface $userInterface)
    {
        parent::__construct();
        $this->middleware('jwtauth')->except([]);
        $this->middleware('jwtnoauth')->only([]);
        $this->user = $userInterface;
    }
    public function indexCustomer()
    {
        return view('customer.index');
    }
    public function createReport()
    {
        // dd(request()->all());
        // dd();
        return $this->user->createReport();
    }
    public function getReports()
    {
        return $this->user->getReports();
    }
    public function reportPage()
    {
        return view('customer.report');
    }
    public function register()
    { }
    public function login()
    { }
    public function logout()
    { }
    public function getProfile()
    { }
    public function updateProfile()
    { }
    public function respondWithToken($token)
    { }
}