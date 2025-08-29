<?php

use App\Http\Controllers\Admin\HistoricalEventController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\NewsBroadcastController;
use App\Http\Controllers\Admin\ParallelUniverseController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UniverseController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [UniverseController::class, 'index'])->name('home');
Route::get('/universes/{universe}', [UniverseController::class, 'show'])->name('universes.show');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');
Route::get('/media/{id}/{dimensions}', [MediaController::class, 'serve'])->name('media.serve');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('universes', ParallelUniverseController::class);
    Route::get('events/mass-upload', [HistoricalEventController::class, 'massUploadForm'])->name('events.mass-upload');
    Route::post('events/mass-upload', [HistoricalEventController::class, 'massUploadProcess'])->name('events.mass-upload.process');
    Route::resource('events', HistoricalEventController::class);
    Route::resource('news', NewsBroadcastController::class);
    Route::get('media/api', [MediaController::class, 'api'])->name('media.api');
    Route::resource('media', MediaController::class);
});

require __DIR__.'/auth.php';
