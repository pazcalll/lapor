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

    public function processPage()
    {
        return view('admin.process');
    }

    public function finishedPage()
    {
        return view('admin.finished');
    }

    public function getUnacceptedReports()
    {
        $data = $this->admin->getUnacceptedReports();
        return datatables($data)->toJson();
    }

    public function getOfficers()
    {
        $data = $this->admin->getOfficers();
        return datatables($data)->toJson();
    }

    public function processReport()
    {
        return $this->admin->processReport();
    }

    public function getAcceptedReports()
    {
        $acceptedReports = $this->admin->getAcceptedReports();
        return datatables($acceptedReports)->toJson();
    }

    public function getFinishedReports()
    {
        $finishedReports = $this->admin->getFinishedReports();
        return datatables($finishedReports)->toJson();
    }
}