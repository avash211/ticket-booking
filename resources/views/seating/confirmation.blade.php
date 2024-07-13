@extends('layouts.app')

@section('content')
    <div class="container page-background">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Confirm Your Booking for {{ $movie->title }}</div>

                    <div class="card-body">
                        <p><strong>Selected Seats:</strong> {{ implode(', ', $selectedSeatNumbers) }}</p>
                        <p><strong>Total Seats Selected:</strong> {{ count($selectedSeatNumbers) }}</p>
                        <p><strong>Total Price:</strong> Rs.{{ number_format($totalPrice, 2) }}</p>

                        <form id="confirmForm" method="post"
                              action="{{ route('seating.book', ['slug' => $movie->slug, 'show_time_id' => $showTime->id]) }}">
                            @csrf
                            <input type="hidden" name="selectedSeats" value="{{ implode(',', $selectedSeatNumbers) }}">
                            <input type="hidden" name="totalSeats" value="{{ count($selectedSeatNumbers) }}">
                            <input type="hidden" name="totalPrice" value="{{ $totalPrice }}">

                            <button type="submit" class="btn btn-success">Pay and Book Seats</button>
                            <br><br>
                            <a href="{{ route('seating.layout', ['slug' => $movie->slug, 'show_time_id' => $showTime->id]) }}" class="btn btn-danger">Back to Layout</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .page-background {
            padding-top: 56px;
        }

        .card-header {
            text-align: center;
        }
    </style>
@endsection
