@extends('adminlte::page')

@section('content')
    <div class="container">
        <div style="margin-top: 20px;">
            <h2>Comments Management</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Movie Title</th>
                        <th>Comment</th>
                        <th>Comment Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comments as $comment)
                        <tr>
                            <td>{{ $comment->user->name }}</td>
                            <td>{{ $comment->movie->title }}</td>
                            <td>{{ $comment->comment }}</td>
                            <td>{{ \Carbon\Carbon::parse($comment->created_at)->format('h:i A jS F, Y') }}</td>
                            <td>
                                <form action="{{ route('admin.comments.delete', ['comment' => $comment->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this comment?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
