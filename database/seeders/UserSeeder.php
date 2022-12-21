<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserAddressDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::beginTransaction();
        $admin = User::create([
            'name' => 'admin',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '123467890'
        ]);
        for ($i = 0; $i < 3; $i++) {
            $customer = User::create([
                'name' => 'user' . $i,
                'username' => 'user' . $i,
                'password' => Hash::make('password'),
                'role' => 'customer',
                'phone' => '123467890',
                'appointment_letter' => '339640.png'
            ]);
            $customerAddressDetail = UserAddressDetail::create([
                'street' => "Jalan " . $i,
                'rt' => "0" . $i,
                'rw' => "0" . $i,
                'village' => "Desa " . $i,
                'sub_district' => "Kecamatan " . $i,
                'user_id' => $customer->id,
            ]);
            $opd = User::create([
                'name' => 'opd' . $i,
                'username' => 'opd' . $i,
                'password' => Hash::make('password'),
                'role' => 'opd',
                'phone' => '123467890'
            ]);
            $opdAddressDetail = UserAddressDetail::create([
                'street' => "Jalan OPD " . $i,
                'rt' => "0" . $i,
                'rw' => "0" . $i,
                'village' => "Desa OPD " . $i,
                'sub_district' => "Kecamatan OPD " . $i,
                'user_id' => $opd->id
            ]);
        }
        DB::commit();
    }
}
