@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Search Results</h1>
    @if($movies->isEmpty())
        <p>No movies found matching your query.</p>
    @else
        <div class="row">
            @foreach($movies as $movie)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img class="card-img-top" src="{{ asset('storage/' . $movie->img) }}" alt="{{ $movie->title }}">
                       <div class="card-body">
                            <h5 class="card-title">{{ $movie->title }}</h5>
                            <p class="card-text">{{ \Illuminate\Support\Str::limit($movie->description, 100, '...') }}</p>
                            <a href="{{ route('movies.details', $movie->slug) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
