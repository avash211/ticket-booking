<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Comment;
use App\Models\ShowTime;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    public function create()
    {
        return view('movies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'age_rating' => 'nullable|string|max:255',
            'runtime' => 'nullable|integer',
            'year' => 'nullable|integer',
            'language' => 'nullable|string|max:255',
            'genres' => 'nullable|string|max:255',
            'director' => 'nullable|string|max:255',
            'cast' => 'nullable|string',
            'seat_price' => 'required|numeric|min:0',
            'trailer' => 'nullable|string|max:255',
            'show_times' => 'required|array', // Ensure show_times is an array
            'show_times.*.show_date' => 'required|date',
            'show_times.*.show_time' => 'required|date_format:H:i',
        ]);

        $movie = new Movie();
        $movie->title = $request->title;
        $movie->description = $request->description;
        $movie->age_rating = $request->age_rating;
        $movie->runtime = $request->runtime;
        $movie->year = $request->year;
        $movie->language = $request->language;
        $movie->genres = $request->genres;
        $movie->director = $request->director;
        $movie->cast = $request->cast;
        $movie->seat_price = $request->seat_price;
        $movie->trailer = $request->trailer;
        $movie->slug = Str::slug($request->title);

        // Handle movie image upload
        if ($request->hasFile('img')) {
            $imagePath = $request->file('img')->store('movie_images', 'public');
            $movie->img = $imagePath;
        }

        $movie->save();

        // Process show times
        foreach ($request->show_times as $showTimeData) {
            ShowTime::create([
                'movie_id' => $movie->id,
                'show_date' => $showTimeData['show_date'],
                'show_time' => $showTimeData['show_time'],
            ]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Movie added successfully.');
    }

    public function showDetails($slug)
    {
        // Fetch movie details by slug
        $movie = Movie::where('slug', $slug)->firstOrFail();

        // Fetch comments for the movie
        $comments = Comment::where('movie_id', $movie->id)->get();

        // Retrieve show time for the movie
        $showTime = ShowTime::where('movie_id', $movie->id)->first();

        if (!$showTime) {
            // Handle case where no show time is found
            return redirect()->back()->with('error', 'No show time found for this movie.');
        }

        // Return view for movie details with necessary data
        return view('movies.details', [
            'movie' => $movie,
            'comments' => $comments,
            'showTime' => $showTime, // Pass $showTime to the view
        ]);
    }

    public function storeComment(Request $request, $slug)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $user = Auth::user();

        // Find the movie by slug
        $movie = Movie::where('slug', $slug)->firstOrFail();

        // Create the comment
        $comment = Comment::create([
            'movie_id' => $movie->id,
            'user_id' => $user->id,
            'name' => $user->name,
            'comment' => $request->input('comment'),
        ]);

        return response()->json([
            'success' => true,
            'comment' => [
                'name' => $comment->name,
                'comment' => $comment->comment,
                'formatted_created_at' => $comment->created_at->format('h:i A jS F, Y'),
            ],
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $movies = Movie::where('title', 'LIKE', "%{$query}%")->get();

        return view('movies.search-results', compact('movies'));
    }
}
