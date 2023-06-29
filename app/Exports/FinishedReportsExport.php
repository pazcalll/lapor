<?php

namespace App\Exports;

use App\Models\Report;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FinishedReportsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function headings(): array
    {
        return [
            'No. Pelaporan',
            'Waktu Pelaporan',
            'Waktu Penugasan',
            'Waktu Selesai',
            'Fasilitas',
            'Deskripsi Laporan',
            'Nama Pelapor',
            'No. Ponsel'
        ];
    }

    public function collection()
    {
        //
        $report = Report::with([
            "assignment" => function ($query) {
                return $query->select('id', 'user_id', 'report_id', 'additional', 'created_at', 'finished_at', 'file_finish');
            },
            "assignment.opd" => function ($query) {
                return $query->select('id', 'name', 'role');
            },
            "reporter" => function ($query) {
                return $query->select('id', 'name', 'phone', 'role');
            },
            "facility" => function ($query) {
                return $query->select('id', 'name');
            },
            "reportLocation" => function ($query) {
                return $query->select('street', 'rt', 'rw', 'sub_district', 'village', 'report_id');
            },
        ])
        ->select('id', 'referral', 'facility_id', 'user_id', 'issue', 'status', 'created_at')
        ->where('status', "LAPORAN TELAH SELESAI")
        ->get()->toArray();

        foreach ($report as $key => $val) {
            $arr[] = [
                'No. Pelaporan' => $val['referral'],
                'Waktu Pelaporan' => $val['created_at'],
                'Waktu Penugasan' => $val['assignment']['created_at'],
                'Waktu Selesai' => $val['assignment']['finished_at'],
                'Fasilitas' => $val['facility']['name'],
                'Deskripsi Laporan' => $val['issue'],
                'Nama Pelapor' => $val['reporter']['name'],
                'No. Ponsel' => $val['reporter']['phone']
            ];
        }
        return new Collection($arr);
    }
}
