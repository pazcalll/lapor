<?php

namespace App\Repositories;

use App\Models\Assignment;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class OpdRepository extends UsersRepository
{
    public function getIncomingAssignments()
    {
        $user = JWTAuth::toUser(request()->bearerToken());
        $assignments = Assignment::with([
            'opd' => function ($query) {
                return $query->select('id', 'name');
            }, 'report' => function ($query) {
                return $query->select('id', 'user_id', 'referral', 'facility_id', 'issue', 'status', 'created_at', 'deadline_at');
            }, 'report.reporter' => function ($query) {
                return $query->select('id', 'name');
            }, 'report.reportLocation' => function ($query) {
                return $query->select('id', 'street', 'rt', 'rw', 'sub_district', 'village', 'report_id');
            }, 'report.reportFile' => function ($query) {
                return $query->select('proof_file', 'report_id');
            }, 'report.facility' => function ($query) {
                return $query->select('id', 'name');
            }
        ])
            ->whereHas('report', function ($query) {
                return $query->where('status', 'SEDANG DIPROSES');
            })
            ->where('user_id', $user['id'])
            ->whereNull('file_finish')
            ->get();
        return $assignments;
    }

    public function getFinishedAssignments()
    {
        $user = JWTAuth::toUser(request()->bearerToken());
        $assignments = Assignment::with([
            'opd' => function ($query) {
                return $query->select('id', 'name');
            }, 'report' => function ($query) {
                return $query->select('id', 'user_id', 'referral', 'facility_id', 'issue', 'status', 'created_at');
            }, 'report.reporter' => function ($query) {
                return $query->select('id', 'name');
            }, 'report.reportLocation' => function ($query) {
                return $query->select('id', 'street', 'rt', 'rw', 'sub_district', 'village', 'report_id');
            }, 'report.reportFile' => function ($query) {
                return $query->select('proof_file', 'report_id');
            }, 'report.facility' => function ($query) {
                return $query->select('id', 'name');
            }
        ])
            ->whereHas('report', function ($query) {
                return $query->where('status', 'LAPORAN TELAH SELESAI');
            })
            ->where('user_id', $user['id'])
            ->whereNotNull('file_finish')
            ->get();
        return $assignments;
    }

    public function finishAssignment()
    {
        try {
            $validator = request()->validate([
                'referral' => 'required|max:12',
                'file_finish' => 'required|file|max:1024|mimes:png,jpg,pdf,jpeg'
            ], [
                'max' => 'Ukuran berkas maksimal 1 MB'
            ]);
            DB::beginTransaction();

            $filename = time() . '_' . request()->file('file_finish')->getClientOriginalName();
            request()->file('file_finish')->storeAs('public/finish', $filename);

            $user_id = JWTAuth::toUser(request()->header('Authorization'))['id'];
            $assignmentUpdate = Assignment::whereHas('report', function ($query) {
                return $query->where('referral', request()->post('referral'));
            })
                ->whereNull('file_finish')
                ->update([
                    'file_finish' => 'storage/finish/' . $filename,
                    'finished_at' => Carbon::now()
                ]);
            $reportUpdate = Report::where('referral', request()->post('referral'))
                ->update([
                    'status' => 'LAPORAN TELAH SELESAI'
                ]);

            DB::commit();
            return response()->json(['success' => true, 'status' => 200], 200);
        } catch (\Exception $th) {
            return response()->json(["error" => $th], 500);
        }
    }
}
