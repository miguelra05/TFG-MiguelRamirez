<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
//vista pública del cv
Route::get('/cv/export', [App\Http\Controllers\CVController::class, 'exportPdf'])->name('cv.export');
Route::get('/cv/{user}', [App\Http\Controllers\CVController::class, 'showPublic'])->name('cv.public');

//vista pública portafolio
Route::get('/portfolio/{user}', [App\Http\Controllers\DocumentController::class, 'publicIndex'])->name('portfolio.public');

// vista pública del perfil
Route::get('/profile/{user}', [ProfileController::class, 'showPublic'])->name('profile.public');

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

    //curriculum
    Route::get('/cv', [App\Http\Controllers\CVController::class, 'index'])->name('cv.index');

    //certificaciones
    Route::post('/certificaciones', [App\Http\Controllers\CVController::class, 'storeCertificacion'])->name('certificaciones.store');
    Route::delete('/certificaciones/{id}', [App\Http\Controllers\CVController::class, 'destroyCertificacion'])->name('certificaciones.destroy');

    //habilidades
    Route::post('/habilidades', [App\Http\Controllers\CVController::class, 'storeHabilidad'])->name('habilidades.store');
    Route::delete('/habilidades/{id}', [App\Http\Controllers\CVController::class, 'destroyHabilidad'])->name('habilidades.destroy');

    //formaciones
    Route::post('/formaciones', [App\Http\Controllers\CVController::class, 'storeFormacion'])->name('formaciones.store');
    Route::delete('/formaciones/{id}', [App\Http\Controllers\CVController::class, 'destroyFormacion'])->name('formaciones.destroy');

    //experiencias
    Route::post('/experiencias', [App\Http\Controllers\CVController::class, 'storeExperiencia'])->name('experiencias.store');
    Route::delete('/experiencias/{id}', [App\Http\Controllers\CVController::class, 'destroyExperiencia'])->name('experiencias.destroy');

    //descarga pdf
    Route::get('/cv/export', [App\Http\Controllers\CVController::class, 'exportPdf'])->name('cv.export');

    //otros
    Route::get('/api/events', [EventsController::class, 'index']);
    Route::post('/api/events', [EventsController::class, 'store']);
    Route::put('/api/events/{event}', [EventsController::class, 'update']);
    Route::delete('/api/events/{event}', [EventsController::class, 'destroy']);
    Route::get('/api/events/{event}', [EventsController::class, 'show']);

    //para perfil de empresa
    Route::middleware(['auth', 'company'])->group(function () {
        Route::get('/company/employees', [App\Http\Controllers\CompanyController::class, 'employees'])->name('company.employees');
        Route::post('/company/add-employee', [App\Http\Controllers\CompanyController::class, 'addEmployee'])->name('company.addEmployee');
        Route::get('/company/calendar/{employee}', [App\Http\Controllers\CompanyController::class, 'viewEmployeeCalendar'])->name('company.calendar');
        Route::post('/company/calendar/{employee}/event', [App\Http\Controllers\CompanyController::class, 'storeEmployeeEvent'])->name('company.storeEvent');
    });

});

// Ruta pública para documentos (sin autenticación)
Route::get('/documents/public/{document}', [App\Http\Controllers\DocumentController::class, 'publicDownload'])->name('documents.public');

// para visualización del calendario por parte de la empresa
Route::get('/api/events/employee/{id}', [EventsController::class, 'employeeEvents'])->middleware('company');
require __DIR__.'/auth.php';
