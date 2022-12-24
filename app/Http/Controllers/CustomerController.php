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
        return $this->user->createReport();
    }
    public function getReports()
    {
        $data = $this->user->getReports();
        return datatables($data)->toJson();
    }
    public function getUnacceptedReports()
    {
        $data = $this->user->getUnacceptedReports();
        return datatables($data)->toJson();
    }
    public function reportPage()
    {
        return view('customer.report');
    }
    public function reportHistoryPage()
    {
        return view('customer.reportHistory');
    }
    public function createFeedback()
    {
        $feedback = $this->user->createFeedback();
        return $feedback;
    }
}