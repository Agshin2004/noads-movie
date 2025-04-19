<?php

use App\Http\Controllers\MoviesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MoviesController::class, 'index'])->name('index');
Route::get('/watch/{movieId}', [MoviesController::class, 'show'])->name('watch');

// Route::view('/movie', 'single-movie');
