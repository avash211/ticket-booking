<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TicketController extends Controller
{
    public function index()
{
    $userEmail = Auth::user()->email;

    // Query to fetch the seats, related show time details, and hall details for the current user
    $tickets = DB::table('seats')
        ->join('show_times', 'seats.show_time_id', '=', 'show_times.id')
        ->join('halls', 'seats.hall_id', '=', 'halls.id')
        ->join('movies', 'show_times.movie_id', '=', 'movies.id') // Join movies table to get movie title
        ->where('seats.email', $userEmail)
        ->select(
            'show_times.show_date',
            'show_times.show_time',
            'seats.seat_number',
            'halls.name as hall_number',
            'movies.title' // Select the movie title
        )
        ->orderBy('show_times.show_date', 'asc')
        ->orderBy('show_times.show_time', 'asc')
        ->get();

    // Convert the collection to an array and add the validity field
    $tickets = $tickets->map(function ($ticket) {
        $showDateTime = Carbon::parse($ticket->show_date . ' ' . $ticket->show_time);
        $currentDateTime = Carbon::now();

        if ($showDateTime->isFuture() || ($showDateTime->isToday() && $currentDateTime->lt($showDateTime))) {
            $ticket->validity = 'valid';
        } else {
            $ticket->validity = 'expired';
        }

        return $ticket;
    });

    // Sort the tickets by validity, then by show date and time
    $sortedTickets = $tickets->sort(function ($a, $b) {
        if ($a->validity === $b->validity) {
            return $a->show_date <=> $b->show_date ?: $a->show_time <=> $b->show_time;
        }
        return $a->validity === 'valid' ? -1 : 1;
    });

    return view('tickets.index', ['tickets' => $sortedTickets]);
}

}
