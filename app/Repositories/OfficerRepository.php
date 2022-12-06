<?php

namespace App\Repositories;

use App\Models\Assignment;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class OfficerRepository extends UsersRepository
{
    public function getIncomingAssignments()
    {
        $user = JWTAuth::toUser(request()->bearerToken());
        $assignments = Assignment::with([
            'officer' => function ($query) {
                return $query->select('id', 'name');
            }, 'report' => function ($query) {
                return $query->select('id', 'user_id', 'referral', 'issue', 'location', 'status', 'created_at');
            }, 'report.reporter' => function ($query) {
                return $query->select('id', 'name');
            }
        ])
            ->whereHas('report', function ($query) {
                return $query->where('status', '!=', 'SELESAI')->where('status', '!=', 'MENUNGGU');
            })
            ->where('user_id', $user['id'])
            ->get();
        return $assignments;
    }
}