<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\ShowTime;
use App\Models\Seat;

class SeatingLayoutController extends Controller
{
    public function showLayout($slug, $show_time_id)
    {
        // Fetch the show time details with its associated movie
        $showTime = ShowTime::with('movie')->findOrFail($show_time_id);
        $movie = $showTime->movie;

        // Fetch existing seats for this show time
        $seats = Seat::where('show_time_id', $show_time_id)->get();

        // Fetch all show times for the same movie
        $showTimes = ShowTime::where('movie_id', $movie->id)->get();
        $selectedShowTime = $showTime;

        return view('seating.layout', compact('movie', 'seats', 'showTimes', 'selectedShowTime'));
    }

    public function confirmSeats(Request $request, $slug, $show_time_id)
    {
        // Get selected seats from the request
        $selectedSeatNumbers = $request->input('selectedSeats');

        // If $selectedSeatNumbers is an array, implode it to get the comma-separated string
        if (is_array($selectedSeatNumbers)) {
            $selectedSeatNumbers = implode(',', $selectedSeatNumbers);
        }

        // Explode the comma-separated string to get individual seat numbers
        $selectedSeatNumbers = explode(',', $selectedSeatNumbers);

        // Fetch the movie details
        $movie = Movie::where('slug', $slug)->firstOrFail();

        // Fetch the show time details
        $showTime = ShowTime::findOrFail($show_time_id);

        // Calculate total price based on seat price and total seats selected
        $seatPrice = $movie->seat_price; // Assuming seat_price is a property of the Movie model
        $totalSeats = count($selectedSeatNumbers);
        $totalPrice = $seatPrice * $totalSeats;

        return view('seating.confirmation', [
            'movie' => $movie,
            'selectedSeatNumbers' => $selectedSeatNumbers,
            'totalSeats' => $totalSeats,
            'totalPrice' => $totalPrice,
            'showTime' => $showTime,
        ]);
    }

    public function bookSeats(Request $request, $slug, $show_time_id)
    {
        // dd('lite');
        // dd('lite');
        // Validate the incoming request
        $request->validate([
            'selectedSeats' => 'required|string', // Change array to string since it's imploded
        ]);

        // Get data from the request
        $selectedSeatNumbers = explode(',', $request->input('selectedSeats'));
        $totalSeats = count($selectedSeatNumbers); // Count the number of selected seats
        $email = auth()->user()->email;

        // Fetch the show time to get movie_id
        $showTime = ShowTime::findOrFail($show_time_id);

        // Calculate total price based on seat price and total seats selected
        $seatPrice = $showTime->movie->seat_price; // Assuming seat_price is a property of the Movie model
        $totalPrice = $seatPrice * $totalSeats;

        // Create new records for each selected seat
        foreach ($selectedSeatNumbers as $seatNumber) {
            Seat::create([
                'show_time_id' => $show_time_id,
                'movie_id' => $showTime->movie_id,
                'seat_number' => $seatNumber,
                'status' => 'occupied',
                'email' => $email,
            ]);
        }

        // Redirect to the confirmation page with the necessary data
        // return redirect()
        //     ->route('seating.confirm', [
        //         'slug' => $slug,
        //         'show_time_id' => $show_time_id,
        //     ])
        //     ->with([
        //         'selectedSeatNumbers' => $selectedSeatNumbers, // Pass selected seats as an array
        //         'totalPrice' => $totalPrice,
        //     ])

        return redirect()
            ->route('seating.layout', ['slug' => $slug, 'show_time_id' => $show_time_id])
            ->with('success', 'Seats booked successfully!');
    }
}
