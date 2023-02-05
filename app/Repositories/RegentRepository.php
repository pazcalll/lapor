<?php

namespace App\Repositories;

use App\Models\Report;

class RegentRepository extends UsersRepository{
    public function summary()
    {
        $summary = [
            [
                'title' => 'Laporan Masuk',
                'shortDesc' => 'Laporan yang belum ditangani',
                'number' => Report::where('status', 'MENUNGGU DIVERIFIKASI')->count(),
                'meterialIcon' => 'zmdi-case-download',
                'iconColor' => '#c2c2c2'
            ],
            [
                'title' => 'Laporan Tertangani',
                'shortDesc' => 'Laporan yang sedang diproses',
                'number' => Report::where('status', 'SEDANG DIPROSES')->count(),
                'meterialIcon' => 'zmdi-case-play',
                'iconColor' => '#ffae00'
            ],
            [
                'title' => 'Laporan Tertangani',
                'shortDesc' => 'Laporan yang sudah ditangani',
                'number' => Report::where('status', 'LAPORAN TELAH SELESAI')->count(),
                'meterialIcon' => 'zmdi-case-check',
                'iconColor' => '#70c24a'
            ],
        ];
        return response()->json(['data' => $summary]);
    }
}