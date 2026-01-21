<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomFacilityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Booking Routes
    Route::resource('bookings', BookingController::class)->except('show', 'edit', 'update', 'destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Rooms Routes
    Route::resource('rooms', RoomController::class)->except('show');
    // Facilities Routes
    Route::resource('facilities', FacilityController::class)->except('show');
    // Room Facilities Routes
    Route::get('/rooms/{room}/facilities', [RoomFacilityController::class, 'index'])->name('rooms.facilities.index');
    Route::get('/rooms/{room}/facilities/create',
        [RoomFacilityController::class, 'create'])->name('rooms.facilities.create');
    Route::post('/rooms/{room}/facilities', [RoomFacilityController::class, 'store'])->name('rooms.facilities.store');
    Route::delete('/rooms/{room}/facilities/{facility}',
        [RoomFacilityController::class, 'destroy'])->name('rooms.facilities.destroy');
});

require __DIR__ . '/auth.php';
