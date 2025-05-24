<?php

use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\MediaController;
use App\Http\Controllers\api\v1\MoviesController;
use App\Http\Controllers\api\v1\TvController;
use App\Http\Controllers\api\v1\UserController;
use Illuminate\Support\Facades\Route;

// * Movie Related Routes
Route::prefix('movie')->controller(MoviesController::class)->middleware('throttle:api')->group(function () {
    Route::get('{id}', 'show')->name('movieDetails');
    Route::get('trending', 'index')->name('trendingMovies');
    Route::post('addComment', 'addComment')->name('addMovieComment');
});

// * Tv Related Routes
Route::prefix('tv')->controller(TvController::class)->middleware('throttle:api')->group(function () {
    Route::get('{id}', 'show')->name('tvDetails');
    Route::get('/trending', 'index')->name('trendingMovies');
    Route::post('addComment', 'addComment')->name('addTvComment');
});

// * Media Related Routess (MediaController is general controller for misc feature like search, popular movies/tv etc)
Route::prefix('media')->controller(MediaController::class)->middleware('throttle:api')->group(function () {
    Route::get('', 'filter')->name('filter');
    Route::get('/top-rated', 'topRated')->name('topRated');
    Route::get('/search', 'search')->name('search');
    Route::get('/popular', 'popular')->name('popular');
    Route::get('/now-playing', 'nowPlaying')->name('nowPlaying');
    Route::get('/players', 'players')->name('players');
    Route::get('/recommendations', 'recommendations')->name('recommendations');
});

// * Auth Related Routes
Route::prefix('auth')->controller(AuthController::class)->middleware('throttle:api')->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('register', 'register')->name('register');
    Route::post('logout', 'logout')->middleware('auth:api');
    Route::post('refresh', 'refresh')->middleware('auth:api');
    Route::get('check', 'auth')->middleware('auth:api');
});

Route::prefix('user')->controller(UserController::class)->middleware(['throttle:api', 'auth:api'])->group(function () {
    // * Comment Related Routes
    Route::get('comment', 'getUserComments');
    Route::post('comment', 'addComment');
    Route::patch('comment/{comment}', 'editComment');
    Route::delete('comment/{comment}', 'deleteComment');

    // * Now Watching Related Routes
    Route::post('now-watching', 'addNowWatching');
});
