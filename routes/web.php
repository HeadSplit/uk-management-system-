<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LogoutController;
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


Route::group([], function() {
    Route::get('/', function () {
        return view('pages.index');
    })->name('index');
});

Route::group([], function() {
    Route::post('register', RegisterController::class)->name('register');
    Route::post('login', AuthController::class)->name('login');
    Route::post('logout', LogoutController::class)->name('logout');
});
