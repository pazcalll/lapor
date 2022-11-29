<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\Report;
use Illuminate\Support\Facades\DB;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AdminRepository extends UsersRepository
{
    public function getUnacceptedReports()
    {
        $data = Report::where('status', 'MENUNGGU')->get();
        return $data;
    }
}