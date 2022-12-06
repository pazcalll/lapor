<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\Report;
use Illuminate\Support\Facades\DB;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class CustomerRepository extends UsersRepository
{
    public function createReport()
    {
        try {
            $validate = request()->validate([
                'facility' => 'required',
                'location' => 'required',
                'issue' => 'required',
                'proof' => 'required|file|max:1024'
            ], [
                'max' => 'Ukuran berkas maksimal 1 MB'
            ]);
            DB::beginTransaction();

            $filename = time() . '_' . request()->file('proof')->getClientOriginalName();
            request()->file('proof')->storeAs('public/proof', $filename);
            // dd(JWTAuth::toUser(request()->header('Authorization'))['id']);
            $user_id = JWTAuth::toUser(request()->header('Authorization'))['id'];
            $data = [
                'referral' => strtoupper(bin2hex(random_bytes(6))),
                'facility_id' => $validate['facility'],
                'user_id' => JWTAuth::toUser(request()->header('Authorization'))['id'],
                'location' => $validate['location'],
                'issue' => $validate['issue'],
                'proof_file' => "storage/proof/" . $filename,
                'status' => "MENUNGGU"
            ];
            Report::create($data);

            DB::commit();
            return response()->json(['success' => true, 'status' => 200], 200);
        } catch (\Throwable $th) {
            // dd($th);
            return response()->json(['error' => $th, 'status' => 400], 400);
            // try {
            // } catch (\Exception $e) {
            //     return response()->json(['error' => $th, 'status' => 400], 400);
            // }
        }
    }

    public function getReports()
    {
        $user = JWTAuth::toUser(request()->bearerToken());
        $data = Report::where('user_id', $user['id'])->get();
        return $data;
    }
}