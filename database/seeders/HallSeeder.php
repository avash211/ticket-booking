<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HallSeeder extends Seeder
{
    public function run()
    {
        DB::table('halls')->insert([
            ['name' => 'Hall A', 'rows' => 6, 'columns' => 6],
            ['name' => 'Hall B', 'rows' => 5, 'columns' => 5],
            ['name' => 'Hall C', 'rows' => 4, 'columns' => 4],
        ]);
    }
}
