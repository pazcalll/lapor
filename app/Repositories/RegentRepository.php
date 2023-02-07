<?php

namespace App\Repositories;

use App\Models\Report;
use App\Models\User;

class RegentRepository extends UsersRepository{
    public function summary()
    {
        $opd = request()->get('opd') ?? null;

        $incomingReport = Report::where('status', 'MENUNGGU DIVERIFIKASI')->count();

        $processReport = Report::when($opd != 0, function($q) use($opd){
                return $q->whereHas('assignment', function ($query) use($opd) {
                    $query->where('user_id', $opd);
                });
            })
            ->where('status', 'SEDANG DIPROSES')
            ->count();

        $finishedReport = Report::when($opd != 0, function($q) use($opd){
                return $q->whereHas('assignment', function ($query) use($opd) {
                    $query->where('user_id', $opd);
                });
            })
            ->where('status', 'LAPORAN TELAH SELESAI')
            ->count();

        $summary = [
            [
                'title' => 'Laporan Masuk',
                'shortDesc' => 'Laporan yang belum ditangani',
                'number' => $incomingReport,
                'meterialIcon' => 'zmdi-case-download',
                'iconColor' => '#c2c2c2'
            ],
            [
                'title' => 'Laporan Tertangani',
                'shortDesc' => 'Laporan yang sedang diproses',
                'number' => $processReport,
                'meterialIcon' => 'zmdi-case-play',
                'iconColor' => '#ffae00'
            ],
            [
                'title' => 'Laporan Tertangani',
                'shortDesc' => 'Laporan yang sudah ditangani',
                'number' => $finishedReport,
                'meterialIcon' => 'zmdi-case-check',
                'iconColor' => '#70c24a'
            ],
        ];
        return response()->json(['data' => $summary]);
    }

    public function getOpds()
    {
        $data = User::where('role', User::ROLE_OPD)->get();
        return response()->json(['data' => $data], 200);
    }
}