@extends('adminlte::page')

@section('content')
    <div class="container page-background">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="text-align: center">Add New Movie</div>

                    <div class="card-body">
                        <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title"  required>
                            </div>
                            <div class="form-group">
                                <label for="trailer">Trailer URL</label>
                                <input type="text" class="form-control" id="trailer" name="trailer" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="show_times">Show Times:</label>
                                <div id="show-times-container">
                                    <div class="show-time-entry">
                                        <div class="form-row align-items-end">
                                            <div class="col">
                                                <label for="show_date">Date</label>
                                                <input type="date" class="form-control" name="show_times[0][show_date]" required>
                                            </div>
                                            <div class="col">
                                                <label for="show_time">Time</label>
                                                <input type="time" class="form-control" name="show_times[0][show_time]" required>
                                            </div>
                                            <div class="col-auto">
                                                <button type="button" class="btn btn-danger remove-show-time" style="margin-bottom: 1.25rem;">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="add-show-time" class="btn btn-primary">Add Show Time</button>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="img">Movie Image</label>
                                <input type="file" class="form-control" id="img" name="img">
                            </div>
                            <div class="form-group">
                                <label for="age_rating">Age Rating</label>
                                <input type="text" class="form-control" id="age_rating" name="age_rating">
                            </div>
                            <div class="form-group">
                                <label for="runtime">Runtime (mins)</label>
                                <input type="number" class="form-control" id="runtime" name="runtime">
                            </div>
                            <div class="form-group">
                                <label for="year">Year</label>
                                <input type="number" class="form-control" id="year" name="year">
                            </div>
                            <div class="form-group">
                                <label for="language">Original Language</label>
                                <input type="text" class="form-control" id="language" name="language">
                            </div>
                            <div class="form-group">
                                <label for="genres">Genres</label>
                                <input type="text" class="form-control" id="genres" name="genres">
                            </div>
                            <div class="form-group">
                                <label for="director">Director</label>
                                <input type="text" class="form-control" id="director" name="director">
                            </div>
                            <div class="form-group">
                                <label for="cast">Cast</label>
                                <textarea class="form-control" id="cast" name="cast"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="seat_price">Seat Price:</label>
                                <input type="number" step="0.01" class="form-control" id="seat_price" name="seat_price" required>
                            </div>

                            <!-- Show Times Section -->

                            <button type="submit" class="btn btn-success">Add Movie</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let showTimeIndex = 1;
            document.getElementById('add-show-time').addEventListener('click', function() {
                let newShowTimeEntry = document.querySelector('.show-time-entry').cloneNode(true);
                newShowTimeEntry.querySelectorAll('input').forEach(function(input) {
                    input.name = input.name.replace(/\d+/, showTimeIndex);
                    input.value = '';
                });
                document.getElementById('show-times-container').appendChild(newShowTimeEntry);
                showTimeIndex++;
            });

            document.getElementById('show-times-container').addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-show-time')) {
                    event.target.closest('.show-time-entry').remove();
                }
            });
        });
    </script>
@endsection
