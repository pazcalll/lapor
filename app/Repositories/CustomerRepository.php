<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\Feedback;
use App\Models\Report;
use App\Models\ReportFile;
use App\Models\ReportLocation;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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
                'status' => "MENUNGGU DIVERIFIKASI"
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
            },
            'feedback' => function ($query) {
                return $query->select('report_id', 'feedback');
            }
        ])
            ->where('user_id', $user['id'])->whereIn('status', ['LAPORAN TELAH SELESAI', 'SEDANG DIPROSES', 'DITOLAK'])->get();
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
            },
            'reportLocation' => function ($query) {
                return $query->select('street', 'rt', 'rw', 'sub_district', 'village', 'report_id');
            }
        ])
            ->where('user_id', $user['id'])->where('status', 'MENUNGGU DIVERIFIKASI')->get();
        return $data;
    }

    public function createFeedback()
    {
        $validator = Validator::make(request()->all(), [
            'referral' => 'required',
            'feedback' => 'required',
            'rating' => 'required'
        ], [
            'required' => 'Semua field wajib diisi'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 400);
        }

        try {
            DB::beginTransaction();

            $validator = $validator->validate();
            $report = Report::where('referral', $validator['referral'])->first();
            $feedback = Feedback::where('report_id', $validator['referral'])->first();

            if (!empty($feedback)) {
                return response()->json(['errors' => 'Laporan ini sudah diberi feedback'], 400);
            }
            $newFeedback = Feedback::create([
                'report_id' => $report['id'],
                'feedback' => $validator['feedback'],
                'rating' => $validator['rating']
            ]);

            DB::commit();
            return response()->json($newFeedback, 200);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()], 400);
        }
    }
}
