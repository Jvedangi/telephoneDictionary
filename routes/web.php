<?php

use App\Http\Controllers\ContactGroupController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImportExportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::resource('contacts', ContactController::class);

Route::get('/test-results', [ContactController::class, 'getTestResults'])->name('test-results');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('contact-groups', ContactGroupController::class);
    Route::delete('contacts/bulk-delete', [ContactController::class, 'bulkDestroy'])->name('contacts.bulk-destroy');
    Route::resource('contacts', ContactController::class);

    Route::get('import-export', [ImportExportController::class, 'index'])->name('import-export.index');
    Route::post('import', [ImportExportController::class, 'import'])->name('import');
    Route::get('export', [ImportExportController::class, 'export'])->name('export');
});

require __DIR__.'/auth.php';
