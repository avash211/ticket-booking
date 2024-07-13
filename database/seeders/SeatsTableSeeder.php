<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seat;
use App\Models\Movie;

class SeatsTableSeeder extends Seeder
{
    public function run()
    {
        $movie = Movie::firstOrCreate([
            'title' => 'Sample Movie',
            'description' => 'This is a sample movie description.'
        ]);

        $rows = 6;
        $cols = 6;

        for ($i = 0; $i < $rows; $i++) {
            for ($j = 0; $j < $cols; $j++) {
                Seat::create([
                    'seat_number' => chr(65 + $i) . ($j + 1),
                    'status' => 'available',
                    'movie_id' => $movie->id,
                ]);
            }
        }
    }
}
