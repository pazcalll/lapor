<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\Assignment;
use App\Models\Facility;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Enum;
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
            $report = Report::where('referral', $reportData['referral'])->where('status', "MENUNGGU")->first()->toArray();
            if (count($report) == 0) {
                return response()->json(['error' => "Data sudah diproses"], 400);
            }
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

    public function getAcceptedReports()
    {
        // $report = Report::where('status', 'DIPROSES')->get()->toArray();
        $report = Report::with([
            "assignment" => function ($query) {
                return $query->select('id', 'user_id', 'report_id', 'additional', 'created_at');
            },
            "assignment.officer" => function ($query) {
                return $query->select('id', 'name', 'role');
            },
            "reporter" => function ($query) {
                return $query->select('id', 'name', 'role');
            },
            "facility" => function ($query) {
                return $query->select('id', 'name');
            }
        ])->select('id', 'referral', 'facility_id', 'user_id', 'location', 'issue', 'proof_file')->where('status', "DIPROSES")->get()->toArray();
        return $report;
    }

    public function getFinishedReports()
    {
        // $report = Report::where('status', 'DIPROSES')->get()->toArray();
        $report = Report::with([
            "assignment" => function ($query) {
                return $query->select('id', 'user_id', 'report_id', 'additional', 'created_at', 'finished_at', 'file_finish');
            },
            "assignment.officer" => function ($query) {
                return $query->select('id', 'name', 'role');
            },
            "reporter" => function ($query) {
                return $query->select('id', 'name', 'role');
            },
            "facility" => function ($query) {
                return $query->select('id', 'name');
            }
        ])->select('id', 'referral', 'facility_id', 'user_id', 'location', 'issue', 'proof_file')->where('status', "SELESAI")->get()->toArray();
        return $report;
    }

    public function getNonAdminUsers()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return $users;
    }

    public function getEnumUser()
    {
        $type = DB::table('information_schema.columns')
            ->select('column_type')
            ->where('table_schema', 'lapor')
            ->where('table_name', 'users')
            ->where('column_name', 'role')
            ->first();
        $enum = [];
        $flag = 0;
        $newWord = "";
        for ($i = 0; $i < strlen($type->COLUMN_TYPE); $i++) {
            if ($flag == 0 && $type->COLUMN_TYPE[$i] == "'") {
                $flag = 1;
            } else if ($type->COLUMN_TYPE[$i] == "'" && $flag == 1) {
                $enum[] = $newWord;
                $newWord = "";
                $flag = 0;
            } else if ($flag == 1) {
                $newWord = $newWord . $type->COLUMN_TYPE[$i];
            }
        }
        return $enum;
    }

    public function editUser()
    {
        User::where('username', request()->post('username'))->update([
            "role" => request()->post('role')
        ]);
    }

    public function getFacilitiesDatatable()
    {
        $data = Facility::select('id', 'name', 'created_at', 'updated_at')->get();
        return $data;
    }

    public function createFacility()
    {
        $create = Facility::create([
            'name' => request()->post('name')
        ]);
        return $create;
    }

    public function editFacility()
    {
        try {
            DB::beginTransaction();

            $validate = request()->validate([
                'name_old' => 'required',
                'name_new' => 'required',
            ], [
                'required' => 'Semua field wajib diisi'
            ]);
            $edit = Facility::where("name", $validate['name_old'])->update([
                "name" => $validate['name_new']
            ]);

            DB::commit();
            return $edit;
        } catch (\Exception $th) {
            return response()->json(["error" => $th], 400);
        }
    }

    public function deleteFacility()
    {
        try {
            DB::beginTransaction();

            $validate = request()->validate([
                'name_delete' => 'required',
            ], [
                'required' => 'Semua field wajib diisi'
            ]);
            $edit = Facility::where("name", $validate['name_delete'])->delete();

            DB::commit();
            return $edit;
        } catch (\Exception $th) {
            return response()->json(["error" => $th], 400);
        }
    }
}