<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\ShowsController;
use App\Jobs\SendFormTelegram;
use Illuminate\Http\Request;
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
    Route::get('/login', 'showLoginForm')
        ->name('login')
        ->middleware('guest');
    Route::get('/register', 'showRegisterForm')
        ->name('register')
        ->middleware('guest');
    Route::get('/logout', 'logout')
        ->name('logout')
        ->middleware('guest');

    Route::post('/register', 'register')
        ->middleware('guest');
    Route::post('/login', 'login')
        ->middleware('guest');
});

// * User Related Routes
Route::prefix('user')->group(function () {
    Route::get('/favorites', [FavoritesController::class, 'myFavorites'])
        ->name('favorites')
        ->middleware('loggedIn');
});

// * Misc Routes
Route::post('/contact-us', function (Request $request) {
    try {
        $validatedData = $request->validate([
            'email' => 'required',
            'subject' => ['required', 'min:5'],
            'body' => ['required', 'min:10']
        ]);

        dispatch(new SendFormTelegram($validatedData));

        return redirect()->back()->with('success', 'Thank for contacting ZMA Movies. Message sent successfully');
    } catch (\Exception $e) {
        Log::error("Error occured while sending message to admin's telegram {$e->getMessage()}}");
        return redirect()->back()->with('fail', $e->getMessage());
    }
});

// Route::view('/welcome', 'welcome');
