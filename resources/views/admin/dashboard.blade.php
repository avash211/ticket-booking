@extends('adminlte::page')

{{-- @extends('layouts.app') --}}

@section('content')
    <div class="container page-background" style="background-color: white;">
        <h1>Admin Dashboard</h1>
        <b>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text">{{ $totalUsers }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Movies</h5>
                        <p class="card-text">{{ $totalMovies }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Sales</h5>
                        <p class="card-text">Rs.{{ number_format($totalSales, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
        </b>
        <br>

        {{-- <h1>Add a new movie</h1>
        <a href="{{ route('admin.movies.create') }}" class="btn btn-primary">Add New Movie</a>
        <br><br> --}}

        <h1>Ticket Sales</h1>
        <canvas id="ticketSalesChart"></canvas>

        <div style="margin-top: 40px;">
            <h1>Movie Comparison</h1>
            <canvas id="movieComparisonChart"></canvas>
        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ticketSalesCtx = document.getElementById('ticketSalesChart').getContext('2d');
        var ticketSalesChart = new Chart(ticketSalesCtx, {
            type: 'line',
            data: {
                labels: @json($dates),
                datasets: [{
                    label: 'Tickets Sold',
                    data: @json($counts),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });

        var movieComparisonCtx = document.getElementById('movieComparisonChart').getContext('2d');
        var movieTitles = @json(array_column($movies, 'title'));
        var movieSeatsSold = @json(array_column($movies, 'totalSeatsSold'));

        var movieComparisonChart = new Chart(movieComparisonCtx, {
            type: 'bar',
            data: {
                labels: movieTitles,
                datasets: [{
                    label: 'Total Seats Sold',
                    data: movieSeatsSold,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <style>
        .page-background {
            padding-top: 20px;
        }
        .card-title{
            font-size: 30px;
        }
        .row{
            font-size: 40px;
        }
    </style>
@endsection
