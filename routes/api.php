<?php

use App\Http\Controllers\api\v1\MoviesController;
use App\Http\Controllers\api\v1\TvController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;


Route::prefix('movie')->controller(MoviesController::class)->group(function () {
    Route::get('trending', 'index')->name('trendingMovies');
    Route::get('{id}', 'show')->name('movieDetails');
});

Route::prefix('tv')->controller(TvController::class)->group(function () {
    Route::get('/trending', 'index')->name('trendingMovies');
    Route::get('{id}', 'show')->name('tvDetails');
});
