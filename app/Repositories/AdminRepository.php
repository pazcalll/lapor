<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\Assignment;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AdminRepository extends UsersRepository
{
    public function getUnacceptedReports()
    {
        $data = Report::where('status', 'MENUNGGU')->get();
        return $data;
    }

    public function getOfficers()
    {
        $data = User::where('role', 'officer')->get();
        return $data;
    }

    public function processReport()
    {
        // $reportData = [
        //     'referral' => request()->post('referral')
        // ];
        // $report = Report::where('referral', $reportData['referral'])->first()->toArray();
        // dd($report);
        try {
            DB::beginTransaction();
            $reportData = [
                'referral' => request()->post('referral')
            ];
            $report = Report::where('referral', $reportData['referral'])->first()->toArray();
            // dd($report);
            $data = [
                'user_id' => request()->post('officer'),
                'report_id' => $report['id'],
                'additional' => request()->post('additional')
            ];
            $reportUpdate = Report::where('referral', $reportData['referral'])->update(['status' => 'DIPROSES']);
            $assignment = Assignment::create($data);
            DB::commit();
        } catch (\Exception $th) {
            DB::rollback();
            return response()->json(['error' => $th], 500);
        }
    }
}