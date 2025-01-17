<?php

use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/info', function () {
    return Inertia::render('Info');
})->name('info');

Route::get('/photos', [PhotoController::class, 'index'])->name('photo.index');
Route::get('/photo/{id}', [ProfileController::class, 'show'])->name('photo.show');
Route::post('/photo/{id}/edit', [ProfileController::class, 'store'])->name('photo.edit');
Route::post('/photo/{id}', [ProfileController::class, 'store'])->name('photo.store');
Route::patch('/photo/{id}', [ProfileController::class, 'update'])->name('photo.update');
Route::delete('/photo/{id}', [ProfileController::class, 'destroy'])->name('photo.destroy');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
