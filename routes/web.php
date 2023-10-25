<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/crud', function () {
        return view('welcome');
    })->name('crud')->lazy();

    Route::view('about', 'about');
    Route::view('home', 'home');

    Route::get('/profile', function () {
        return view('profile');
    });
});

// Route::get('/logout', function () {
//     Auth::logout();
//     return redirect('/login');
// });

Route::get('/', function () {
    return view('registration');
});

Route::get('/login', function () {
    return view('login');
})->name('login');
