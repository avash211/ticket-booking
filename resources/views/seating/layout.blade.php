@extends('layouts.app')

@section('content')
    <div class="container page-background">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Seating Layout for {{ $movie->title }}</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="sc-title screen mb-4">Screen</div>

                        <div class="seating mb-2">
                            <div class="row row-gap-3 seat-list-wrapper">
                                @php
                                    $rows = ['A', 'B', 'C', 'D', 'E', 'F'];
                                    $cols = range(1, 6);
                                @endphp

                                @foreach ($rows as $row)
                                    @foreach ($cols as $col)
                                        @php
                                            $seatNumber = $row . $col;
                                            $seat = $seats->firstWhere('seat_number', $seatNumber);
                                            $seatStatusClass = $seat
                                                ? ($seat->status === 'occupied'
                                                    ? 'occupied'
                                                    : ($seat->status === 'reserved'
                                                        ? 'reserved'
                                                        : 'available'))
                                                : 'available';
                                        @endphp
                                        <div class="col-2 d-flex">
                                            <div class="seat mx-auto {{ $seatStatusClass }}"
                                                data-seat="{{ $seatNumber }}">{{ $seatNumber }}</div>
                                        </div>
                                    @endforeach
                                @endforeach

                            </div>
                        </div>

                        <form id="seatForm"
                            action="{{ route('seating.confirm', ['slug' => $movie->slug, 'show_time_id' => $selectedShowTime->id]) }}"
                            method="POST">
                            @csrf
                            <input type="hidden" name="selectedSeats[]" id="selectedSeats">

                            <div class="form-group">
                                <label for="showTimeSelect">Select Show Time:</label>
                                <select id="showTimeSelect" class="form-control" name="show_time_id"
                                    onchange="changeShowTime(this)">
                                    @foreach ($showTimes as $showTime)
                                        @php
                                            $showDateTime = \Carbon\Carbon::parse($showTime->show_date . ' ' . $showTime->show_time);
                                            $isPast = $showDateTime < now();
                                        @endphp
                                        <option value="{{ $showTime->id }}"
                                            data-show-date="{{ $showDateTime->format('Y-m-d\TH:i:s') }}"
                                            {{ $showTime->id == $selectedShowTime->id ? 'selected' : '' }}
                                            {{ $isPast ? 'disabled' : '' }}>
                                            {{ $showDateTime->format('M d, Y h:i A') }}
                                            {{ $isPast ? '(Past)' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="button" class="btn btn-success d-block mx-auto" onclick="submitForm()">Confirm Selection</button>
                            <br><br>
                            <a href="{{ route('dashboard') }}" class="btn btn-danger">Back to Dashboard</a>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function submitForm() {
            const selectedSeats = document.querySelectorAll('.seat.selected');
            if (selectedSeats.length === 0) {
                alert('Please select at least one seat.');
                return;
            }

            const selectedSeatNumbers = Array.from(selectedSeats).map(selectedSeat => selectedSeat.getAttribute(
                'data-seat'));
            document.getElementById('selectedSeats').value = selectedSeatNumbers.join(',');

            // Submit the form
            document.getElementById('seatForm').submit();
        }

        document.addEventListener('DOMContentLoaded', () => {
            const seats = document.querySelectorAll('.seat');
            const showTimeSelect = document.getElementById('showTimeSelect');

            seats.forEach(seat => {
                seat.addEventListener('click', () => {
                    if (seat.classList.contains('occupied')) {
                        return; // Prevent selecting occupied seats
                    }

                    seat.classList.toggle('selected');
                });
            });

            // Function to change show time
            function changeShowTime(select) {
                const selectedOption = select.options[select.selectedIndex];
                const selectedShowDate = new Date(selectedOption.getAttribute('data-show-date'));
                const today = new Date();

                // Compare selected date with today's date
                if (selectedShowDate < today) {
                    alert('Please select a future show time.');
                    // Reset the select element to the previously selected valid option
                    select.value = select.dataset.prevValidValue || '';
                    return;
                }

                // Update the previous valid value dataset
                select.dataset.prevValidValue = select.value;

                const showTimeId = select.value;
                const slug = "{{ $movie->slug }}";
                window.location.href = `/seating/layout/${slug}/${showTimeId}`;
            }

            // Call changeShowTime function when the select changes
            showTimeSelect.addEventListener('change', () => {
                changeShowTime(showTimeSelect);
            });
        });
    </script>

    <style>
        .page-background {
            padding-top: 56px;
        }

        .sc-title {
            font-size: 18px;
            font-weight: 700;
            text-align: center;
        }

        .seat-list-wrapper {
            row-gap: 24px;
        }

        .seat {
            width: 50px;
            height: 50px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border: 1px solid hsl(0, 0%, 80%);
            border-radius: 4px;
            cursor: pointer;
            background-color: rgb(70, 220, 70);
            /* Default available color */
            color: white;
        }

        .seat.occupied {
            background: #ff6b6b;
            /* Red for occupied seats */
        }

        .seat.selected {
            background: hsl(0, 60%, 50%);
            /* Light blue for selected seats */
        }

        .card-header {
            text-align: center;
        }

        .btn-success {
            margin-top: 10px;
        }
    </style>
@endsection
