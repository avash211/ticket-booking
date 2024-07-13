<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avash Movies</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .navbar {
            background-color: black !important;
        }

        .navbar-brand {
            font-size: 1.25rem;
            color: white !important;
        }

        .navbar-brand:hover {
            color: gray !important;
        }

        .navbar-toggler {
            border-color: rgba(0, 0, 0, 0.1);
        }

        .navbar-toggler-icon {
            color: white;
        }

        .nav-link {
            color: white !important;
        }

        .nav-link:hover {
            color: gray !important;
        }

        .dropdown-menu {
            min-width: 10rem;
            padding: .5rem 0;
        }

        .dropdown-item {
            color: #343a40 !important;
        }

        .dropdown-item:hover {
            color: gray !important;
            background-color: #f8f9fa !important;
        }

        .container {
            margin-top: 1rem;
        }

        .py-4 {
            padding-top: 1.5rem !important;
            padding-bottom: 1.5rem !important;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .d-none {
            display: none !important;
        }

        main {
            padding-top: 56px;
        }

        body {
            background-color: #262020;
        }

        .page-background {
            padding-top: 56px;
        }

        .card-header {
            text-align: center;
            background-color: #f0f0f0;
            font-weight: bold;
            font-size: 24px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand"
                href="{{ Auth::check() ? (Auth::user()->hasRole('admin') ? url('admin/dashboard') : url('dashboard')) : url('/') }}">
                Avash Movies
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboard">Home</a>
                        </li>
                    @endauth
                </ul>

                <!-- Search Form -->
                <form class="form-inline my-2 my-lg-0 ml-auto" action="{{ route('movies.search') }}" method="GET">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search Movies" aria-label="Search" name="query" required>
                    <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
                </form>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('signup') }}">{{ __('Register') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @else
                        <ul class="navbar-nav mr-auto">
                            @auth
                                <li class="nav-item">
                                    <a class="nav-link" href="/chatify">Chats</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('tickets.index') }}">Tickets</a>
                                </li>
                            @endauth
                        </ul>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <img src="{{ Auth::user()->avatar ? asset('storage/users-avatar/' . Auth::user()->avatar) : asset('storage/users-avatar/avatar.png') }}"
                                    alt="Profile Picture" class="rounded-circle" width="30" height="30"
                                    style="object-fit: cover;">
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    {{ __('Profile') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
