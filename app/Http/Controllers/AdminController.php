<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Seat;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Get total sales grouped by date for line chart
        $salesData = Seat::where('status', 'occupied')->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(id) as count'))->groupBy(DB::raw('DATE(created_at)'))->orderBy('date')->get();

        $dates = $salesData->pluck('date')->toArray();
        $counts = $salesData->pluck('count')->toArray();

        // Get movie details for table, sorted by total sales made in descending order
        $movies = Movie::select('movies.title', 'movies.slug')->selectRaw('COUNT(seats.id) as totalSeatsSold')->selectRaw('SUM(CASE WHEN seats.status = "occupied" THEN movies.seat_price ELSE 0 END) as totalSalesMade')->leftJoin('seats', 'movies.id', '=', 'seats.movie_id')->groupBy('movies.id', 'movies.title', 'movies.slug')->orderByDesc('totalSalesMade')->get()->toArray();

        // Get total number of users
        $totalUsers = User::count();

        // Get total number of movies
        $totalMovies = Movie::count();

        // Get total sales
        $totalSales = Seat::where('status', 'occupied')->sum(DB::raw('(SELECT seat_price FROM movies WHERE id = seats.movie_id)'));

        // Pass data to the view
        return view('admin.dashboard', compact('dates', 'counts', 'movies', 'totalUsers', 'totalMovies', 'totalSales'));
    }

    public function details($slug)
    {
        $movie = Movie::where('slug', $slug)->firstOrFail();

        // Calculate total seats bought
        $totalSeatsBought = Seat::where('movie_id', $movie->id)
            ->where('status', 'occupied')
            ->count();

        // Calculate total sales made
        $totalSales = Seat::where('movie_id', $movie->id)
            ->where('status', 'occupied')
            ->sum(DB::raw('(SELECT seat_price FROM movies WHERE id = seats.movie_id)'));

        // Fetch purchase history
        $purchaseHistory = Seat::where('movie_id', $movie->id)
            ->where('status', 'occupied')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(id) as count'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        $dates = $purchaseHistory->pluck('date')->toArray();
        $counts = $purchaseHistory->pluck('count')->toArray();

        // Pass data to the view
        return view('admin.movies.details', compact('movie', 'totalSeatsBought', 'totalSales', 'dates', 'counts'));
    }
    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        return view('admin.edit', compact('movie'));
    }

    public function update(Request $request, $id)
{
    $movie = Movie::findOrFail($id);
    $movie->update($request->except('show_times'));

    if ($request->hasFile('img')) {
        $movie->img = $request->file('img')->store('images', 'public');
    }

    $movie->save();

    // Update Show Times
    $movie->showTimes()->delete(); // Delete old show times
    foreach ($request->input('show_times', []) as $showTime) {
        $movie->showTimes()->create($showTime);
    }

    return redirect()
        ->route('admin.movies.details', $movie->slug) // Assuming 'slug' is the attribute storing the movie's slug
        ->with('success', 'Movie updated successfully');
}


    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Movie deleted successfully');
    }

    public function sales()
    {
        // Get movies sorted by total sales made in descending order
        $movies = Movie::select('title', 'slug')
                       ->selectRaw('COUNT(seats.id) as totalSeatsSold')
                       ->selectRaw('SUM(CASE WHEN seats.status = "occupied" THEN movies.seat_price ELSE 0 END) as totalSalesMade')
                       ->leftJoin('seats', 'movies.id', '=', 'seats.movie_id')
                       ->groupBy('movies.id', 'movies.title', 'movies.slug')
                       ->orderByDesc('totalSalesMade')
                       ->get();

        return view('admin.movies.sales', compact('movies'));
    }
    public function users()
    {
        $users = User::select('id', 'name', 'email', 'created_at', 'role')
            ->where('role', '!=', 'admin') // Exclude users with role 'admin'
            ->withCount(['seats as totalSeatsBooked' => function ($query) {
                $query->where('status', 'occupied');
            }])
            ->get();

        return view('admin.user', compact('users'));
    }


    public function deleteUser(User $user)
    {
        // Delete user and related seats
        $user->seats()->delete(); // Optional: Delete seats associated with the user
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully');
    }
}
