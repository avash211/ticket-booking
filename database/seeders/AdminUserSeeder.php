<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Avash Shrestha',
            'email' => 'avashshrestha13@gmail.com',
            'password' => Hash::make('hakuavash211'),
            'role' => 'admin',
        ]);
    }
}
