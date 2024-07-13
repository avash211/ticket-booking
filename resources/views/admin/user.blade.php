@extends('adminlte::page')

@section('content')
    <div class="container">
        <div style="margin-top: 20px;">
            <h2>User Details</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Total Seats Booked</th>
                        <th>Joined Date</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->totalSeatsBooked }}</td>
                            <td>{{ \Carbon\Carbon::parse($user->created_at)->isoFormat('Do MMMM YYYY') }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                <form action="{{ route('admin.users.delete', ['user' => $user->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
