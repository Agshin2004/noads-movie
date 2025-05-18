<?php

use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\MediaController;
use App\Http\Controllers\api\v1\MoviesController;
use App\Http\Controllers\api\v1\TvController;
use Illuminate\Support\Facades\Route;

// * Movie Related Routes
Route::prefix('movie')->controller(MoviesController::class)->group(function () {
    Route::get('trending', 'index');
    Route::get('{id}', 'show');
});

// * Tv Related Routes
Route::prefix('tv')->controller(TvController::class)->group(function () {
    Route::get('/trending', 'index');
    Route::get('{id}', 'show');
});

// * Media Related Routess (MediaController is general controller for misc feature like search, popular movies/tv etc)
Route::prefix('media')->controller(MediaController::class)->group(function () {
    Route::get('', 'filter');
    Route::get('/top-rated', 'topRated');
    Route::get('/search', 'search');
    Route::get('/popular', 'popular');
    Route::get('/now-playing', 'nowPlaying');
    Route::get('/players', 'players');
    Route::get('/recommendations', 'recommendations');
});

// * Auth Related Routes
Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout')->middleware('auth:api');
    Route::post('refresh', 'refresh')->middleware('auth:api');
    Route::get('check', 'auth')->middleware('auth:api');
});
