<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //calendario
    Route::get('/calendar', function () {
        return view('calendar.index');
    })->name('calendar.index');
    //portafolio
    Route::get('/documents', [App\Http\Controllers\DocumentController::class, 'index'])->name('documents.index');
    Route::post('/documents', [App\Http\Controllers\DocumentController::class, 'store'])->name('documents.store');
    Route::delete('/documents/{document}', [App\Http\Controllers\DocumentController::class, 'destroy'])->name('documents.destroy');
    Route::patch('/documents/{document}/visibility', [App\Http\Controllers\DocumentController::class, 'updateVisibility'])->name('documents.visibility');
    Route::get('/documents/download/{document}', [App\Http\Controllers\DocumentController::class, 'download'])->name('documents.download');

    Route::get('/api/events', [EventsController::class, 'index']);
    Route::post('/api/events', [EventsController::class, 'store']);
    Route::put('/api/events/{event}', [EventsController::class, 'update']);
    Route::delete('/api/events/{event}', [EventsController::class, 'destroy']);
    Route::get('/api/events/{event}', [EventsController::class, 'show']);
});
// Ruta pública para documentos (sin autenticación)
Route::get('/documents/public/{document}', [App\Http\Controllers\DocumentController::class, 'publicDownload'])->name('documents.public');
require __DIR__.'/auth.php';
