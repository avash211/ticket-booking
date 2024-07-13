@extends('layouts.app')

@section('content')
    <div class="container page-background">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Movie List</div>

                    <div class="card-body">
                        {{-- Today's Shows --}}
                        @if ($todaysMovies->isNotEmpty())
                            <h2 class="title">Today's Shows</h2>
                            <div class="row">
                                @foreach ($todaysMovies as $showTime)
                                    @if ($showTime->movie)
                                        <div class="col-md-4 mb-4">
                                            <div class="card movie-card">
                                                <img class="card-img-top" src="{{ asset('storage/' . $showTime->movie->img) }}" alt="{{ $showTime->movie->title }}">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">{{ $showTime->movie->title }}</h5>
                                                    <a href="{{ route('movies.details', ['slug' => $showTime->movie->slug]) }}" class=" btn-success mb-2">View Details</a>
                                                    <a href="{{ route('seating.layout', ['slug' => $showTime->movie->slug, 'show_time_id' => $showTime->id]) }}" class="btn btn-view">Book Tickets</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        {{-- Upcoming Shows --}}
                        @if ($upcomingMovies->isNotEmpty())
                            <h2 class="title">Upcoming Shows</h2>
                            <div class="row">
                                @foreach ($upcomingMovies as $showTime)
                                    @if ($showTime->movie)
                                        <div class="col-md-4 mb-4">
                                            <div class="card movie-card">
                                                <img class="card-img-top" src="{{ asset('storage/' . $showTime->movie->img) }}" alt="{{ $showTime->movie->title }}">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">{{ $showTime->movie->title }}</h5>
                                                    <a href="{{ route('movies.details', ['slug' => $showTime->movie->slug]) }}" class="btn btn-success mb-2">View Details</a>
                                                    <a href="{{ route('seating.layout', ['slug' => $showTime->movie->slug, 'show_time_id' => $showTime->id]) }}" class="btn btn-view">Book Tickets</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        {{-- Previous Shows --}}
                        @if ($previousMovies->isNotEmpty())
                            <h2 class="title">Previous Shows</h2>
                            <div class="row">
                                @foreach ($previousMovies as $showTime)
                                    @if ($showTime->movie)
                                        <div class="col-md-4 mb-4">
                                            <div class="card movie-card">
                                                <img class="card-img-top" src="{{ asset('storage/' . $showTime->movie->img) }}" alt="{{ $showTime->movie->title }}">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">{{ $showTime->movie->title }}</h5>
                                                    <a href="{{ route('movies.details', ['slug' => $showTime->movie->slug]) }}" class="btn btn-success mb-2">View Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .title {
            border-radius: 4px;
            background-color: black;
            color: white;
            text-align: center;
            font-weight: 10;
        }

        body {
            background-color: #262020;
        }

        .page-background {
            padding-top: 56px;
        }

        .card-header {
            text-align: center;
            background-color: #6c67677e;
            padding: 10px;
            font-weight: 900;
            font-size: 30px;
        }

        .card-body {
            background-color: #d3d3d3;
        }

        .movie-card {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .movie-card .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-img-top {
            height: 500px;


        }

        .btn-view {
            background-color: purple;
            color: white;
        }

        .btn-view:hover {
            background-color: rgb(223, 12, 188);
        }
    </style>
@endsection
