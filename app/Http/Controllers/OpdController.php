<?php

namespace App\Http\Controllers;

use App\Interfaces\UserInterface;
use Illuminate\Http\Request;

class OpdController extends Controller
{
    private $opd;
    public function __construct(UserInterface $userInterface)
    {
        parent::__construct();
        $this->middleware('jwtauth')->except([]);
        $this->middleware('jwtnoauth')->only([]);
        $this->opd = $userInterface;
    }

    //
    public function homePage()
    {
        return view('opd.home');
    }

    public function historyPage()
    {
        return view('opd.history');
    }

    public function getIncomingAssignments()
    {
        $assignents = $this->opd->getIncomingAssignments();
        return datatables($assignents)->toJson();
    }

    public function finishAssignment()
    {
        return $this->opd->finishAssignment();
    }

    public function getFinishedAssignments()
    {
        $finishedAssignments = $this->opd->getFinishedAssignments();
        return datatables($finishedAssignments)->toJson();
    }
}