<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\TvController;
use App\Http\Controllers\api\v1\MediaController;
use App\Http\Controllers\api\v1\MoviesController;


// * Movie Related Routes
Route::prefix('movie')->controller(MoviesController::class)->group(function () {
    Route::get('trending', 'index')->name('trendingMovies');
    Route::get('{id}', 'show')->name('movieDetails');
});


// * Tv Related Routes
Route::prefix('tv')->controller(TvController::class)->group(function () {
    Route::get('/trending', 'index')->name('trendingMovies');
    Route::get('{id}', 'show')->name('tvDetails');
});



//* Media Related Routess (MediaController is general controller for misc feature like search, popular movies/tv etc)
Route::prefix('media')->controller(MediaController::class)->group(function () {
    Route::get('/search',  'search');
    Route::get('/popular', 'popular');
    Route::get('/now-playing', 'nowPlaying');
;});
