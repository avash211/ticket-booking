@extends('layouts.app')

@section('content')
<div class="container page-background">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Your Profile</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Display Profile Picture -->
                    <div class="text-center mb-3">
                        <img src="{{ $user->avatar ? asset('storage/users-avatar/' . $user->avatar) : asset('storage/users-avatar/avatar.png') }}" alt="Profile Picture" class="profile-picture">
                    </div>

                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Total Movies Watched:</strong> {{ $totalMoviesWatched }}</p>

                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Update Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .profile-picture {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
    }
</style>
@endsection



