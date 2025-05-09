<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\TvController;
use App\Http\Controllers\api\v1\MoviesController;
use App\Http\Controllers\api\v1\SearchController;


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



//* MISC
Route::get('/search', [SearchController::class, 'search']);
