<?php

use App\Http\Controllers\Content\MaterialController;
use App\Http\Controllers\Content\NarrativeController;
use App\Http\Controllers\Content\PhotoController;
use App\Http\Controllers\Content\VideoController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    Route::prefix('konten')->group(function () {
        Route::get('video', [VideoController::class, 'index'])->name('content.video');
        Route::post('video', [VideoController::class, 'store'])->name('content.video.store');

        Route::get('foto', [PhotoController::class, 'index'])->name('content.photo');
        Route::post('foto', [PhotoController::class, 'store'])->name('content.photo.store');

        Route::get('narasi', [NarrativeController::class, 'index'])->name('content.narrative');
        Route::post('narasi', [NarrativeController::class, 'store'])->name('content.narrative.store');

        Route::get('materi', [MaterialController::class, 'index'])->name('content.material');
        Route::post('materi', [MaterialController::class, 'store'])->name('content.material.store');
    });

    Route::get('konsultasi', function () {
        return Inertia::render('consultation/index');
    })->name('consultation.index');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
