<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TimelineController;

use Illuminate\Support\Facades\Route;

Route::get('/', [CategoryController::class, 'index'])->name('index');

    Route::post('/categories', [CategoryController::class, 'store']);

    Route::get('/categories/{id}', [CategoryController::class, 'show']);

    Route::post('/categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');

    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    Route::post('/events', [EventController::class, 'store'])->name('events.store');

    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');

    Route::put('/images/update/{id}', [ImageController::class, 'update'])->name('images.update');

Route::post('/events/by-categories', [TimelineController::class, 'index'])->name('events.byCategories');


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__ . '/auth.php';
