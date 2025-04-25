<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\ShowsController;
use Illuminate\Support\Facades\Route;

// * Route to Movie or TV
Route::get('/watch/{type}/{id}', function ($type, $id) {
    return match ($type) {
        // Create a new redirect response to a controller action
        'movie' => redirect()->action([MoviesController::class, 'show'], ['movieId' => $id]),
        'tv' => redirect()->action([ShowsController::class, 'show'], ['showId' => $id])
    };
})->where('type', 'movie|tv');  // assert that type must be either movie or tv (meaning show)

// * Movie Related Routes
Route::get('/', [MoviesController::class, 'index'])->name('index');
Route::get('/movie/{movieId}', [MoviesController::class, 'show'])->name('watchMovie');

// * TV Related Routes
Route::get('/show/{showId}', [ShowsController::class, 'show'])->name('watchShow');

// * People (AKA Actors) Related Routes
Route::get('/people/{personId}', [PeopleController::class, 'show'])->name('person');

// * Auth Related Routes
Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::get('/login',  'showLoginForm')
        ->name('login');
    Route::get('/register',  'showRegisterForm')
        ->name('register');
    Route::get('/logout', 'logout')->name('logout');
    
    Route::post('/register', 'register');
});

Route::view('/welcome', 'welcome');
