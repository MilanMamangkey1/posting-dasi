<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ConsultationRequestController;
use App\Http\Controllers\Admin\EducationalContentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontend\ConsultationController as FrontendConsultationController;
use App\Http\Controllers\Frontend\HomeController as FrontendHomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendHomeController::class, 'index'])->name('public.home');
Route::post('/consultation', [FrontendConsultationController::class, 'store'])->name('public.consultations.store');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function (): void {
    Route::prefix('admin')->group(function (): void {
        Route::get('/', [AdminDashboardController::class, 'view'])->name('admin.dashboard.ui');
        Route::get('/contents', [AdminDashboardController::class, 'contents'])->name('admin.contents.index');
        Route::get('/consultations', [AdminDashboardController::class, 'consultations'])->name('admin.consultations.index');

        Route::post('/contents', [EducationalContentController::class, 'store'])->name('admin.contents.store');
        Route::put('/contents/{educational_content}', [EducationalContentController::class, 'update'])->name('admin.contents.update');
        Route::delete('/contents/{educational_content}', [EducationalContentController::class, 'destroy'])->name('admin.contents.destroy');

        Route::put('/consultations/{consultation_request}', [ConsultationRequestController::class, 'update'])->name('admin.consultations.update');
        Route::delete('/consultations/{consultation_request}', [ConsultationRequestController::class, 'destroy'])->name('admin.consultations.destroy');

        Route::prefix('api')
        ->name('admin.api.')
        ->group(function (): void {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

            Route::apiResource('educational-contents', EducationalContentController::class)
                ->except(['create', 'edit']);

            Route::apiResource('consultation-requests', ConsultationRequestController::class)
                ->except(['create', 'edit']);
        });
    });
});
