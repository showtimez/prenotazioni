<?php

use App\Models\Reservation;
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



Route::get('/prenota', [ReservationController::class, 'create'])->name('prenota');
Route::get('/prenota/update', [ReservationController::class, 'update']);
Route::post('/prenota/store', [ReservationController::class, 'store']);

Route::post('/reservations/{reservation}/reject', [ReservationController::class, 'reject'])->name('reservations.reject');

Route::post('/reservations/{reservation}/update-table-reservation', [ReservationController::class, 'updateTable']);


// home admin
Route::get('/admin/home',[AdminController::class, 'index'])->name('admin.index');



// rifiuta prenotazione
Route::patch('/rifiuta/prenotazione/{reservation}', [AdminController::class, 'rejectReservation'])->name('admin.reject_reservation');

// Reset reservation
Route::post('/reservations/{reservation}/reset', [AdminController::class, 'resetReservation'])->name('reservations.reset');
// Reject reservation
Route::post('/reservations/{reservation}/reject', [AdminController::class, 'rejectReservation'])->name('reservations.reject');


Route::post('/reservations/{reservation}/update-table-reservation', [AdminController::class, 'updateTable'])->name('reservations.update-table');



Route::post('/reservations/{reservation}/update-table', [ReservationController::class, 'updateTable']);

// Route::get('/reservations/{token}/accept', [ReservationController::class, 'acceptViaEmail']);
// Route::get('/reservations/{token}/reject', [ReservationController::class, 'rejectViaEmail']);

Route::post('/reservations/form/toggle', [AdminController::class, 'update'])->name('reservations.form.toggle');
Route::get('/reservations/{reservation}/accept', function (Reservation $reservation) {
    return view('reservations.accept', ['reservation' => $reservation]);
})->name('reservations.accept-page');
Route::post('/reservations/{reservation}/accept', [ReservationController::class, 'acceptReservation'])->name('reservations.accept');
Route::post('/reservations/{reservation}/reject', [ReservationController::class, 'rejectReservation'])->name('reservations.reject');




Route::post('/admin/generate-tables', [AdminController::class, 'storeTables']);
