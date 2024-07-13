<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\ShowTime;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $currentDateTime = Carbon::now();

        // Fetch today's movies considering both date and time from show_times
        $todaysMovies = ShowTime::with('movie')
            ->whereDate('show_date', $currentDateTime->toDateString())
            ->whereTime('show_time', '>=', $currentDateTime->toTimeString())
            ->orderBy('show_time', 'asc')
            ->get();

        // Fetch upcoming movies considering both date and time from show_times
        $upcomingMovies = ShowTime::with('movie')
            ->whereDate('show_date', '>', $currentDateTime->toDateString())
            ->orWhere(function ($query) use ($currentDateTime) {
                $query->whereDate('show_date', '>', $currentDateTime->toDateString())
                    ->whereTime('show_time', '>', $currentDateTime->toTimeString());
            })
            ->orderBy('show_date', 'asc')
            ->orderBy('show_time', 'asc')
            ->get();

        // Fetch previous movies considering both date and time from show_times
        $previousMovies = ShowTime::with('movie')
            ->whereDate('show_date', '<', $currentDateTime->toDateString())
            ->orWhere(function ($query) use ($currentDateTime) {
                $query->whereDate('show_date', '=', $currentDateTime->toDateString())
                    ->whereTime('show_time', '<', $currentDateTime->toTimeString());
            })
            ->orderBy('show_date', 'desc')
            ->orderBy('show_time', 'desc')
            ->get();

        $firstMovie = $todaysMovies->first();

        if ($firstMovie) {
            $showTimes = ShowTime::where('movie_id', $firstMovie->movie_id)->get();
            $selectedShowTime = $showTimes->first();
        } else {
            $showTimes = collect();
            $selectedShowTime = null;
        }

        return view('dashboard', compact('todaysMovies', 'upcomingMovies', 'previousMovies', 'selectedShowTime', 'showTimes'));
    }
}
