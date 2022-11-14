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
        $user = User::create([
            'name' => 'user1',
            'username' => 'user1',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => 'asdf'
        ]);
        DB::commit();
    }
}