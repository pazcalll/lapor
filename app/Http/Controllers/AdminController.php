<?php

namespace App\Http\Controllers;

use App\Interfaces\UserInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    private $admin;
    public function __construct(UserInterface $userInterface)
    {
        parent::__construct();
        $this->middleware('jwtauth')->except([]);
        $this->middleware('jwtnoauth')->only([]);
        $this->admin = $userInterface;
    }

    public function homePage()
    {
        return view('admin.home');
    }

    public function getUnacceptedReports()
    {
        $data = $this->admin->getUnacceptedReports();
        return datatables($data)->toJson();
    }
}