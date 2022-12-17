<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [];
        $facility = ['Infrastruktur (Jalan, Tiang PJU, Jembatan, Sanitasi Air)', 'Kesehatan', 'Pendidikan', 'Keamanan dan Ketertiban', 'Administrasi'];
        foreach ($facility as $key => $value) {
            $data[] = ['name' => $value];
        }
        foreach ($data as $key => $value) {
            Facility::create($value);
        }
    }
}