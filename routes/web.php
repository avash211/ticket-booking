<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SeatingLayoutController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;


// Landing page
Route::get('/', function () {
    return view('signup');
});

// Authentication routes
Route::get('/signup', [RegistrationController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [RegistrationController::class, 'processSignup']);

Route::get('/login', [RegistrationController::class, 'showLoginForm'])->name('login');
Route::post('/login', [RegistrationController::class, 'processLogin'])->name('login.submit');
Route::post('/logout', [RegistrationController::class, 'logout'])->name('logout');

//Login
Route::post('/login', [LoginController::class, 'login'])->name('login');
// Dashboard route for authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //profile

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/updateAvatar', [ProfileController::class, 'updateAvatar'])->name('profile.updateAvatar');
    Route::delete('/profile/deleteAvatar', [ProfileController::class, 'deleteAvatar'])->name('profile.deleteAvatar');
    Route::post('/profile/changePassword', [ProfileController::class, 'changePassword'])->name('profile.changePassword');

    // Movie routes
    Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
    Route::get('/movies/create', [MovieController::class, 'create'])->name('movies.create');
    Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');
    Route::get('/movies/details/{slug}', [MovieController::class, 'showDetails'])->name('movies.details');
    Route::get('/search', [MovieController::class, 'search'])->name('movies.search');

    // Seating routes

    Route::get('/seating/layout/{slug}/{show_time_id}', [SeatingLayoutController::class, 'showLayout'])->name('seating.layout');
    Route::post('/seating/confirm/{slug}/{show_time_id}', [SeatingLayoutController::class, 'confirmSeats'])->name('seating.confirm');
    Route::post('/seating/book/{slug}/{show_time_id}', [SeatingLayoutController::class, 'bookSeats'])->name('seating.book');

    // Ticket routes
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');


    // Comment route
    Route::post('/movies/{slug}/comments', [MovieController::class, 'storeComment'])->name('movies.comments.store');
    Route::get('admin/comments', [CommentController::class, 'index'])->name('admin.comments');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('admin.comments.delete');

    // Admin routes
    Route::middleware(['auth', 'checkrole:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/movies/create', [MovieController::class, 'create'])->name('admin.movies.create');
        Route::get('/admin/movies/sales', [AdminController::class, 'sales'])->name('admin.movies.sales');
        Route::get('/admin/movies/details/{slug}', [AdminController::class, 'details'])->name('admin.movies.details');
        Route::post('/admin/movies', [MovieController::class, 'store'])->name('admin.movies.store');
        Route::get('/admin/movies/{movie}/edit', [AdminController::class, 'edit'])->name('admin.movies.edit');
        Route::put('/admin/movies/{movie}', [AdminController::class, 'update'])->name('admin.movies.update');
        Route::delete('movies/{movie}', [AdminController::class, 'destroy'])->name('admin.movies.destroy');
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    });
});
