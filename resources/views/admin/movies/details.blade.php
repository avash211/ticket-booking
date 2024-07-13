@extends('adminlte::page')

@section('content')
    <div class="container">
         <!-- Update and Delete Buttons -->
         <div class="mt-3">
            <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-success">Update Movie</a>

            <!-- Form for Delete Movie with Confirmation -->
            <form id="deleteForm" action="{{ route('admin.movies.destroy', $movie->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete {{ $movie->title }}?')">Delete Movie</button>
            </form>
        </div>
        <br>
        <h1>Details of {{ $movie->title }}</h1>

        <!-- Total Seats Bought -->
        <div class="card">
            <div class="card-body">
                <h5>Total Seats Bought: {{ $totalSeatsBought }}</h5>
            </div>
        </div>

        <!-- Total Sales Made -->
        <div class="card mt-3">
            <div class="card-body">
                <h5>Total Sales Made: Rs.{{ $totalSales }}</h5>
            </div>
        </div>

        <!-- Purchase History Chart -->
        <div class="card mt-3">
            <canvas id="purchaseHistoryChart" width="800" height="400"></canvas>
        </div>

        <!-- Back Button -->
        <a href="{{ route('admin.dashboard') }}" class="btn btn-danger mt-3 ">Back to Dashboard</a>
    </div>

    <!-- Include Chart.js -->
    @section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('purchaseHistoryChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($dates) !!},
                    datasets: [{
                        label: 'Tickets Sold',
                        data: {!! json_encode($counts) !!},
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Tickets Sold'
                            }
                        }
                    },
                    layout: {
                        padding: {
                            left: 10,
                            right: 10,
                            top: 10,
                            bottom: 10
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    elements: {
                        line: {
                            borderWidth: 1,
                            tension: 0.4,
                        },
                        point: {
                            radius: 3,
                            hitRadius: 10,
                            hoverRadius: 4,
                        }
                    }
                }
            });
        });
    </script>
    @endsection
@endsection
