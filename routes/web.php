<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Restaurant\RestaurantDashboardController;
use App\Http\Controllers\Restaurant\RestaurantGalleryController;
use App\Http\Controllers\Restaurant\RestaurantMemberController;
use App\Http\Controllers\Restaurant\RestaurantReservationController;
use App\Http\Controllers\Restaurant\RestaurantTableController;
use App\Http\Controllers\Restaurant\RestaurantSettingsController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show'])->name('restaurants.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware([
    'auth',
    'verified',
])->name('dashboard');

Route::middleware('auth')->group(function () {
    // reservation routes
    Route::get('/reservations/restaurant/{restaurant}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations/restaurant/{restaurant}', [ReservationController::class, 'store'])->name('reservations.store');

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

            Route::patch('/reservations/{reservation}/confirm', [
                RestaurantReservationController::class,
                'confirm'
            ])->name('reservations.confirm');

            Route::get('/reservations/{reservation}/edit', [
                RestaurantReservationController::class,
                'edit'
            ])->name('reservations.edit');

            Route::put('/reservations/{reservation}', [
                RestaurantReservationController::class,
                'update'
            ])->name('reservations.update');

            /*
            |--------------------------------------------------------------------------
            | Members
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


            Route::get('/gallery', [
                RestaurantGalleryController::class,
                'index'
            ])->name('gallery.index');

            Route::post('/gallery', [
                RestaurantGalleryController::class,
                'store'
            ])->name('gallery.store');

            Route::patch('/gallery/order', [
                RestaurantGalleryController::class,
                'updateOrder'
            ])->name('gallery.order');


            Route::delete('/gallery/{image}', [
                RestaurantGalleryController::class,
                'destroy'
            ])->name('gallery.destroy');

            /*
            |--------------------------------------------------------------------------
            | Settings
            |--------------------------------------------------------------------------
            */

            Route::get('/settings', [
                RestaurantSettingsController::class,
                'edit'
            ])->name('settings.edit');

            Route::put('/settings', [
                RestaurantSettingsController::class,
                'update'
            ])->name('settings.update');



        });

});

require __DIR__.'/auth.php';
