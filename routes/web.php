<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReservationController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/prenota', [ReservationController::class, 'create']);
Route::post('/prenota', [ReservationController::class, 'store']);
Route::post('/reservations/{reservation}/accept', [ReservationController::class, 'accept'])->name('reservations.accept');
Route::post('/reservations/{reservation}/reject', [ReservationController::class, 'reject'])->name('reservations.reject');


// home admin
Route::get('/admin/home',[AdminController::class, 'index'])->name('admin.index');

// accetta prenotazione
Route::patch('/accetta/prenotazione/{reservation}', [AdminController::class, 'acceptReservation'])->name('admin.accept_reservation');

// rifiuta prenotazione
Route::patch('/rifiuta/prenotazione/{reservation}', [AdminController::class, 'rejectReservation'])->name('admin.reject_reservation');

Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::post('/reservations/{reservation}/update-table', [AdminController::class, 'updateTable'])->name('reservations.update-table');

Route::post('/reservations/{reservation}/update', [ReservationController::class, 'update']);

Route::post('/reservations/{reservation}/update-table', [ReservationController::class, 'updateTable']);

Route::get('/reservations/{token}/accept', [ReservationController::class, 'acceptViaEmail']);
Route::get('/reservations/{token}/reject', [ReservationController::class, 'rejectViaEmail']);

Route::post('/reservations/form/toggle', 'ReservationController@toggleForm')->name('reservations.form.toggle');
