@extends('layouts.app')

@section('content')
    <div class="container page-background">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $movie->title }}</div>

                    <div class="card-body">
                        <div class="text-center">
                            @if ($movie->img)
                                <img src="{{ asset('storage/' . $movie->img) }}" class="img-fluid mb-3" alt="{{ $movie->title }}">
                            @else
                                <p>No image available</p>
                            @endif
                        </div>
                        <p class="text-justify"><strong>Description:</strong> {{ $movie->description }}</p>
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($movie->date)->format('M d, Y') }}</p>
                        <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($movie->time)->format('h:i A') }}</p>
                        <p><strong>Age Rating:</strong> {{ $movie->age_rating }}</p>
                        <p><strong>Runtime:</strong> {{ $movie->runtime }} mins</p>
                        <p><strong>Year:</strong> {{ $movie->year }}</p>
                        <p><strong>Original Language:</strong> {{ $movie->language }}</p>
                        <p><strong>Genres:</strong> {{ $movie->genres }}</p>
                        <p><strong>Director:</strong> {{ $movie->director }}</p>
                        <p><strong>Cast:</strong> {{ $movie->cast }}</p>
                        <p><strong>Price per Seat:</strong> Rs.{{ $movie->seat_price }}</p>

                        <p><strong>Trailer:</strong>
                        @if ($movie->trailer)
                            @php
                                $videoId = '';
                                if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $movie->trailer, $match)) {
                                    $videoId = $match[1];
                                } elseif (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $movie->trailer, $match)) {
                                    $videoId = $match[1];
                                } elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $movie->trailer, $match)) {
                                    $videoId = $match[1];
                                }
                            @endphp

                            @if ($videoId)
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                </div>
                            @else
                                <p>Invalid trailer URL.</p>
                            @endif
                        @endif
                        </p>
                        <a href="{{ route('dashboard') }}" class="btn btn-danger">Back to Dashboard</a>
                    </div>
                </div>

             {{-- Comment Section --}}
             <div class="card mt-3">
                <div class="card-header">Comments</div>
                <div class="card-body" id="comments-section">
                    @foreach ($comments as $comment)
                        <div class="mb-3">
                            <strong>{{ $comment->name }}</strong>
                            <small class="text-muted">({{ \Carbon\Carbon::parse($comment->created_at)->format('h:i A jS F, Y') }})</small>
                            <p>{{ $comment->comment }}</p>

                        </div>
                    @endforeach

                    {{-- Form to Add Comment --}}
                    <form id="comment-form">
                        @csrf
                        <div class="form-group">
                            <label for="comment">Add Comment:</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('comment-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const comment = document.getElementById('comment').value;
        const token = document.querySelector('input[name="_token"]').value;

        fetch('{{ route('movies.comments.store', ['slug' => $movie->slug]) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({
                comment: comment
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const commentSection = document.getElementById('comments-section');
                const newComment = document.createElement('div');
                newComment.classList.add('mb-3');
                newComment.innerHTML = `<strong>${data.comment.name}</strong><p>${data.comment.comment}</p><small class="text-muted">${data.comment.formatted_created_at}</small>`;
                commentSection.insertBefore(newComment, commentSection.children[commentSection.children.length - 1]);

                document.getElementById('comment').value = '';
            } else {
                alert('Failed to add comment.');
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>
@endsection
