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
        $customer = User::create([
            'name' => 'user1',
            'username' => 'user1',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '123467890'
        ]);
        $admin = User::create([
            'name' => 'admin',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '123467890'
        ]);
        $officer = User::create([
            'name' => 'officer',
            'username' => 'officer',
            'password' => Hash::make('password'),
            'role' => 'officer',
            'phone' => '123467890'
        ]);
        DB::commit();
    }
}