<?php

use App\Http\Controllers\MoviesController;
use App\Http\Controllers\PeopleController;
use Illuminate\Support\Facades\Route;

//* Movie Related Routes
Route::get('/', [MoviesController::class, 'index'])->name('index');
Route::get('/watch/{movieId}', [MoviesController::class, 'show'])->name('watch');

//* TV Related Routes (not implemented)

//* People Related Routes
Route::get('/people/{personId}', [PeopleController::class, 'show'])->name('person');


// Route::view('/movie', 'single-movie');
