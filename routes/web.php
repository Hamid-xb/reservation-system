<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantDashboardController;
use App\Http\Controllers\RestaurantTableController;
use App\Http\Controllers\RestaurantReservationController;
use App\Http\Controllers\RestaurantMemberController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware([
    'auth',
    'verified',
])->name('dashboard');

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Restaurant
    |--------------------------------------------------------------------------
    */

    Route::prefix('restaurant/{restaurant}')
        ->name('restaurant.')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Dashboard
            |--------------------------------------------------------------------------
            */

            Route::get('/dashboard', [
                RestaurantDashboardController::class,
                'index'
            ])->name('dashboard');

            /*
            |--------------------------------------------------------------------------
            | Tables
            |--------------------------------------------------------------------------
            */

            Route::get('/tables', [
                RestaurantTableController::class,
                'index'
            ])->name('tables.index');

            Route::post('/tables', [
                RestaurantTableController::class,
                'store'
            ])->name('tables.store');

            Route::put('/tables/{table}', [
                RestaurantTableController::class,
                'update'
            ])->name('tables.update');

            Route::delete('/tables/{table}', [
                RestaurantTableController::class,
                'destroy'
            ])->name('tables.destroy');

             /*
             |--------------------------------------------------------------------------
             | Reservations
             |--------------------------------------------------------------------------
             */

            Route::get('/reservations', [
                RestaurantReservationController::class,
                'index'
            ])->name('reservations.index');

            Route::patch('/reservations/{reservation}/status', [
                RestaurantReservationController::class,
                'updateStatus'
            ])->name('reservations.update-status');

            Route::delete('/reservations/{reservation}', [
                RestaurantReservationController::class,
                'destroy'
            ])->name('reservations.destroy');

            /*
            |--------------------------------------------------------------------------
            | Reservations
            |--------------------------------------------------------------------------
            */

            Route::get('/members', [
                RestaurantMemberController::class,
                'index'
            ])->name('members.index');

            Route::post('/members', [
                RestaurantMemberController::class,
                'store'
            ])->name('members.store');

            Route::patch('/members/{userRole}', [
                RestaurantMemberController::class,
                'update'
            ])->name('members.update');

            Route::delete('/members/{userRole}', [
                RestaurantMemberController::class,
                'destroy'
            ])->name('members.destroy');

        });

});

require __DIR__.'/auth.php';
