<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Private\UserController;
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
    Route::get('/about', function () {
        return view('pages.about');
    })->name('about');
    Route::get('/contact', function () {
        return view('pages.contact');
    })->name('contact');

    Route::group(['middleware' => 'auth'], function() {
        Route::get('/personal', [UserController::class, 'showUserInvoices'])->name('personal');
        Route::get('/requests', [UserController::class, 'showRequests'])->name('requests');
        Route::get('/invoices', [UserController::class, 'showInvoices'])->name('invoices');
        Route::get('/houses', [UserController::class, 'showHouses'])->name('houses');
        Route::get('/apartments', [UserController::class, 'showApartments'])->name('apartments');
        Route::get('/users', [UserController::class, 'showUsers'])->name('users');
    });
});

Route::group([], function() {
    Route::post('/register', RegisterController::class)->name('register');
    Route::post('/login', AuthController::class)->name('login');
    Route::post('/logout', LogoutController::class)->name('logout');
});
