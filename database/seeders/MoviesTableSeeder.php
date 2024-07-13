<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;

class MoviesTableSeeder extends Seeder
{
    public function run()
    {
        // Define movie titles and descriptions
        $movieData = [
            ['title' => 'Movie A', 'description' => 'Description for Movie A.'],
            ['title' => 'Movie B', 'description' => 'Description for Movie B.'],
            ['title' => 'Movie C', 'description' => 'Description for Movie C.'],
            // Add more movies as needed
        ];

        // Insert data into database
        foreach ($movieData as $data) {
            Movie::create($data);
        }
    }
}
