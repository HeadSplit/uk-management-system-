<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Private\ApartmentController;
use App\Http\Controllers\Private\HouseController;
use App\Http\Controllers\Private\InvoiceController;
use App\Http\Controllers\Private\RequestController;
use App\Http\Controllers\Private\ServiceController;
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
    Route::get('/houses/{houseId}/apartments', [HouseController::class, 'getApartments'])
        ->name('house.apartments');

    Route::group(['middleware' => 'auth'], function() {
        Route::get('/personal', [UserController::class, 'showUserInvoices'])->name('personal');
        Route::get('/requests', [UserController::class, 'showRequests'])->name('requests');
        Route::get('/invoices', [UserController::class, 'showInvoices'])->name('invoices');
        Route::get('/apartments/{apartment}/send-metrics', [ApartmentController::class, 'showSendMetricsForm'])
            ->name('apartments.send-metrics.form');
        Route::post('/apartments/{apartment}/send-metrics', [ApartmentController::class, 'sendMetrics'])
            ->name('apartments.send-metrics');
        Route::get('/houses', [UserController::class, 'showHouses'])->name('houses');
        Route::get('/apartments', [UserController::class, 'showApartments'])->name('apartments');
        Route::get('/users', [UserController::class, 'showUsers'])->name('users');
        Route::put('/apartments/{apartment}/users/{user}', [ApartmentController::class, 'detachUser'])
            ->name('apartments.users.detach');
        Route::post('/apartments/{apartment}/send-metrics', [ApartmentController::class, 'sendMetrics'])
            ->name('apartments.send-metrics');
        Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
        Route::get('invoices/{invoice}/download', [InvoiceController::class, 'downloadPdf'])->name('invoices.download');
        Route::get('/services', [ServiceController::class, 'index'])->name('services');
        Route::get('/requests/create', [RequestController::class, 'create'])->name('requests.create');
        Route::post('/requests', [RequestController::class, 'store'])->name('requests.store');
        Route::get('/requests/{request}', [RequestController::class, 'show'])->name('requests.show');

        Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

        Route::middleware('can:admin')->group(function () {;
            Route::post('/users/create', [UserController::class, 'store'])->name('users.store');
            Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
            Route::put('/users/update/{user}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/users/delete/{user}', [UserController::class, 'destroy'])->name('users.delete');

            Route::get('/houses/create', [HouseController::class, 'create'])->name('houses.create');
            Route::post('/houses/create', [HouseController::class, 'store'])->name('houses.store');
            Route::get('/houses/edit/{house}', [HouseController::class, 'edit'])->name('houses.edit');
            Route::put('/houses/update/{house}', [HouseController::class, 'update'])->name('houses.update');
            Route::delete('/houses/delete/{house}', [HouseController::class, 'destroy'])->name('houses.delete');

            Route::get('/apartments/create', [ApartmentController::class, 'create'])->name('apartments.create');
            Route::post('/apartments/create', [ApartmentController::class, 'store'])->name('apartments.store');
            Route::get('/apartments/edit/{apartment}', [ApartmentController::class, 'edit'])->name('apartments.edit');
            Route::put('/apartments/update/{apartment}', [ApartmentController::class, 'update'])->name('apartments.update');
            Route::delete('/apartments/delete/{apartment}', [ApartmentController::class, 'destroy'])->name('apartments.delete');
            Route::post('/apartments/store-resident', [ApartmentController::class, 'storeResident'])
                ->name('apartments.storeResident');
            Route::post('/apartments/detach-resident', [ApartmentController::class, 'detachUser'])
                ->name('apartments.users.detach');



            Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
            Route::post('/invoices/create', [InvoiceController::class, 'store'])->name('invoices.store');
            Route::get('/invoices/edit/{invoice}', [InvoiceController::class, 'edit'])->name('invoices.edit');
            Route::put('/invoices/update/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');
            Route::delete('/invoices/delete/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.delete');

            Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
            Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
            Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
            Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
            Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.delete');

            Route::get('/requests/edit/{requestModel}', [RequestController::class, 'edit'])
                ->name('requests.edit');
            Route::put('/requests/{requestModel}', [RequestController::class, 'update'])
                ->name('requests.update');
            Route::delete('/requests/{requestModel}', [RequestController::class, 'destroy'])
                ->name('requests.delete');
        });
    });


});

Route::group([], function() {
    Route::post('/register', RegisterController::class)->name('register');
    Route::post('/login', AuthController::class)->name('login');
    Route::post('/logout', LogoutController::class)->name('logout');
});
