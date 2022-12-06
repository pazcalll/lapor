<?php

namespace App\Http\Controllers;

use App\Interfaces\UserInterface;
use Illuminate\Http\Request;

class OfficerController extends Controller
{
    private $officer;
    public function __construct(UserInterface $userInterface)
    {
        parent::__construct();
        $this->middleware('jwtauth')->except([]);
        $this->middleware('jwtnoauth')->only([]);
        $this->officer = $userInterface;
    }

    //
    public function homePage()
    {
        return view('officer.home');
    }

    public function getIncomingAssignments()
    {
        $assignents = $this->officer->getIncomingAssignments();
        return datatables($assignents)->toJson();
    }

    public function finishAssignment()
    {
        return $this->officer->finishAssignment();
    }
}