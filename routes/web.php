<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MoviesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



//Route::get('/', [MoviesController::class, 'index'])->name('movies.index');
Route::get('/kinoklad/{year?}/{country?}/{rating?}', [MoviesController::class, 'index'])
    ->name('movies.index')
    ->where([
        'year' => '[0-9]{4}',
        'country' => '.*', // Разрешить любые символы в стране
        'rating' => '[0-9]{1,2}',
    ]);

Auth::routes();

Route::get('/kinoklad/{movie}', [MoviesController::class, 'show'])->name('movies.show');
Route::post('/kinoklad/{movie}/rate', [MoviesController::class, 'rate'])->name('movies.rate');
Route::post('/kinoklad/{movie}/comments', [CommentController::class, 'store'])->name('comments.store');

Route::get('/home', [HomeController::class, 'index'])->name('home');
