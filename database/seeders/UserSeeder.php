<?php

namespace Database\Seeders;

use App\Models\User;
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
                'phone' => '123467890'
            ]);
            $officer = User::create([
                'name' => 'officer' . $i,
                'username' => 'officer' . $i,
                'password' => Hash::make('password'),
                'role' => 'officer',
                'phone' => '123467890'
            ]);
        }
        DB::commit();
    }
}