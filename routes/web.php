<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TweetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', [TweetController::class, 'index'])
    ->name('home');

Route::get('/register', [RegisterController::class, 'create'])
    ->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'create'])
    ->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::post('/logout', LogoutController::class)
    ->name('logout');

Route::get('/tweet/{tweet}', [TweetController::class, 'view'])
    ->name('tweet.view');
Route::post('/tweet/create', [TweetController::class, 'store'])
    ->name('tweet.create');

Route::middleware('auth')->group(function () {
    Route::post('/tweets/{tweet}/like', [TweetController::class, 'like'])->name('tweets.like');
    Route::delete('/tweets/{tweet}/like', [TweetController::class, 'unlike'])->name('tweets.unlike');
});

Route::get('/users/{user}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/@{username}', [ProfileController::class, 'byUsername'])->name('profile.byUsername');

Route::middleware('auth')->group(function () {
    
    Route::patch('/users/{user}', [ProfileController::class, 'update'])
        ->name('profile.update');
});