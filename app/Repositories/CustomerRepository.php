<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\Report;
use Illuminate\Support\Facades\DB;

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

            $data = [
                'referral' => strtoupper(bin2hex(random_bytes(6))),
                'facility_id' => $validate['facility'],
                'location' => $validate['location'],
                'issue' => $validate['issue'],
                'proof_file' => $filename,
                'status' => "MENUNGGU"
            ];
            Report::create($data);

            DB::commit();
            return response()->json(['success' => true, 'status' => 200], 200);
        } catch (\Throwable $th) {
            // dd($th);
            try {
                return response()->json(['error' => $th->errors(), 'status' => 400], 400);
            } catch (\Exception $e) {
                return response()->json(['error' => $th, 'status' => 400], 400);
            }
        }
    }
}