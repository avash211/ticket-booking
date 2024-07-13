@extends('adminlte::page')

@section('content')
<div class="container">
    <div style="margin-top: 20px;">
        <h2>Movie Sales Details</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Total Seats Sold</th>
                    <th>Total Sales Made</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach($movies as $movie)
                    <tr class="{{ $movie->totalSeatsSold < 10 ? 'table-danger' : '' }}">
                        <td>{{ $movie->title }}</td>
                        <td>{{ $movie->totalSeatsSold }}</td>
                        <td>{{ $movie->totalSalesMade }}</td>
                        <td>
                            <a href="{{ route('admin.movies.details', ['slug' => $movie->slug]) }}" class="btn btn-success btn-sm">Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
