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

    public function incomingPage()
    {
        return view('admin.incoming');
    }

    public function processPage()
    {
        return view('admin.process');
    }

    public function finishedPage()
    {
        return view('admin.finished');
    }

    public function configPage()
    {
        return view('admin.config');
    }

    public function facilitiesPage()
    {
        return view('admin.facilities');
    }

    public function getUnacceptedReports()
    {
        $data = $this->admin->getUnacceptedReports();
        return datatables($data)->toJson();
    }

    public function getOpds()
    {
        $data = $this->admin->getOpds();
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

    public function getNonAdminUsers()
    {
        $users = $this->admin->getNonAdminUsers();
        return datatables($users)->toJson();
    }

    public function getEnumUser()
    {
        $enum = $this->admin->getEnumUser();
        return response()->json($enum, 200);
    }

    public function editUser()
    {
        $edit = $this->admin->editUser();
        return $edit;
    }

    public function getFacilitiesDatatable()
    {
        $data = $this->admin->getFacilitiesDatatable();
        return datatables($data)->toJson();
    }

    public function createOpd()
    {
        $data = $this->admin->createOpd();
        return $data;
    }

    public function createFacility()
    {
        $create = $this->admin->createFacility();
        return $create;
    }

    public function editFacility()
    {
        $edit = $this->admin->editFacility();
        return $edit;
    }
    public function deleteFacility()
    {
        $delete = $this->admin->deleteFacility();
        return $delete;
    }
    public function registerCustomer()
    {
        $register = $this->admin->registerCustomer();
        return $register;
    }
    public function rejectReport()
    {
        $reject = $this->admin->rejectReport();
        return $reject;
    }
    public function editReport()
    {
        $edit = $this->admin->editReport();
        return $edit;
    }
    public function updateCustomer()
    {
        $update = $this->admin->updateCustomer();
        return $update;
    }
    public function updateOpd()
    {
        $update = $this->admin->updateOpd();
        return $update;
    }
    public function changeUserStatus()
    {
        $user = $this->admin->changeUserStatus();
        return $user;
    }
    public function getFinishedReportsExcel()
    {
        $excel = $this->admin->getFinishedReportsExcel();
        return $excel;
    }
    public function changeAssignmentOpd()
    {
        return $this->admin->changeAssignmentOpd();
    }

    public function summary()
    {
        return $this->admin->summary();
    }
}
