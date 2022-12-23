<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\Report;
use App\Models\ReportFile;
use App\Models\ReportLocation;
use Exception;
use Illuminate\Support\Facades\DB;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class CustomerRepository extends UsersRepository
{
    public function createReport()
    {
        try {
            $validate = request()->validate([
                'facility' => 'required',
                'rt' => 'required',
                'rw' => 'required',
                'street' => 'required',
                'village' => 'required',
                'sub_district' => 'required',
                'issue' => 'required',
                'proof.*' => 'required|file|max:1024'
            ], [
                'required' => 'Semua atribut wajib diisi',
                'file' => 'Atribut bukti harus dalam bentuk file',
                'proof.*.max' => 'Ukuran berkas maksimal 1 MB'
            ]);
            DB::beginTransaction();

            $newReport = [
                'referral' => strtoupper(bin2hex(random_bytes(6))),
                'facility_id' => $validate['facility'],
                'user_id' => JWTAuth::toUser(request()->header('Authorization'))['id'],
                'issue' => $validate['issue'],
                'status' => "MENUNGGU"
            ];
            $createReport = Report::create($newReport);

            foreach ($validate['proof'] as $key => $value) {
                $filename = time() . '_' . $value->getClientOriginalName();
                $reportFile = [
                    'proof_file' => $filename,
                    'report_id' => $createReport->id
                ];
                ReportFile::create($reportFile);
                $value->storeAs('public/proof', $filename);
            }

            $reportLocation = [
                'street' => $validate['street'],
                'rt' => $validate['rt'],
                'rw' => $validate['rw'],
                'sub_district' => $validate['sub_district'],
                'village' => $validate['village'],
                'report_id' => $createReport->id
            ];

            ReportLocation::create($reportLocation);

            DB::commit();
            return response()->json(['success' => true, 'status' => 200], 200);
        } catch (Exception $th) {
            return response()->json(['error' => $th, 'status' => 400], 400);
        }
    }

    public function getReports()
    {
        $user = JWTAuth::toUser(request()->bearerToken());
        $data = Report::with([
            'reportFile' => function ($query) {
                return $query->select('report_id', 'proof_file');
            },
            'facility' => function ($query) {
                return $query->select('id', 'name');
            },
            'assignment' => function ($query) {
                return $query->select('report_id', 'user_id', 'file_finish', 'finished_at');
            },
            'assignment.opd' => function ($query) {
                return $query->select('id', 'name');
            }
        ])
            ->where('user_id', $user['id'])->whereIn('status', ['SELESAI', 'DIPROSES', 'DITOLAK'])->get();
        return $data;
    }

    public function getUnacceptedReports()
    {
        $user = JWTAuth::toUser(request()->bearerToken());
        $data = Report::with([
            'reportFile' => function ($query) {
                return $query->select('report_id', 'proof_file');
            },
            'facility' => function ($query) {
                return $query->select('id', 'name');
            }
        ])
            ->where('user_id', $user['id'])->where('status', 'MENUNGGU')->get();
        return $data;
    }
}