<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecordingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('recordings.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // RECORDING ROUTES
    Route::get('/recordings', [RecordingController::class, 'index'])->name('recordings.index');
    Route::post('/recordings', [RecordingController::class, 'store'])->name('recordings.store');
    Route::delete('/recordings/{id}', [RecordingController::class, 'destroy'])->name('recordings.destroy');
});

require __DIR__.'/auth.php';


