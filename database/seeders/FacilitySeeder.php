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
        $data = [
            ['name' => 'Stasiun Bus'],
            ['name' => 'Tiang Listrik'],
            ['name' => 'Selokan']
        ];
        foreach ($data as $key => $value) {
            Facility::create($value);
        }
    }
}