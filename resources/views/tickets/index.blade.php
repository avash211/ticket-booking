<!-- resources/views/tickets/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container page-background">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="header-custom" style="text-align: center; color:white;">Booked Tickets</div>

                @if(session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table table-custom mt-3">
                    <thead>
                        <tr>
                            <th>Movie Title</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Seat Number</th>
                            <th>Hall Number</th>
                            <th>Validation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->title }}</td>
                                <td>{{ \Carbon\Carbon::parse($ticket->show_date)->format('M d, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($ticket->show_time)->format('h:i A') }}</td>
                                <td>{{ $ticket->seat_number }}</td>
                                <td>{{ $ticket->hall_number }}</td>
                                <td>
                                    @if ($ticket->validity === 'valid')
                                        <span class="badge badge-success">Valid</span>
                                    @else
                                        <span class="badge badge-danger">Expired</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No tickets booked.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <a href="{{ route('dashboard') }}" class="btn btn-danger mt-3">Back to Dashboard</a>
            </div>
        </div>
    </div>

    <style>
        .page-background {
            padding-top: 56px;
        }

        .header-custom {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .table-custom th, .table-custom td {
            padding: 15px;
            font-size: 16px;
            background-color: white;

        }

        .alert {
            font-size: 16px;
        }

        .badge {
            font-size: 14px;
        }

        .btn {
            font-size: 16px;
        }
        /* thead{
            color: white;

        }
        tbody{
            color: white;

        } */
    </style>
@endsection
