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
    public function homePage()
    {
        return view('customer.home');
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
    public function reportHistoryPage()
    {
        return view('customer.reportHistory');
    }
}