<?php

use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\S3Controller;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/info', function () {
    return Inertia::render('Info');
})->name('info');

Route::get('/photos', [PhotoController::class, 'index'])->name('photo.index');
Route::post('/photo', [PhotoController::class, 'store'])->name('photo.store');
Route::post('/photo/{id}', [PhotoController::class, 'update'])->name('photo.update');
Route::delete('/photo/{id}', [PhotoController::class, 'destroy'])->name('photo.destroy');


Route::get("/s3/start-multipart-upload", [S3Controller::class, "StartMultipartUpload"])->name("s3.multipart.start");
Route::get("/s3/generate-presigned-multipart-url", [S3Controller::class, "GeneratePresignedMultipartUrl"])->name("s3.multipart.presigned-url");
Route::post("/s3/complete-multipart-upload", [S3Controller::class, "CompleteMultipartUpload"])->name("s3.multipart.complete");
Route::get("/s3/generate-presigned-url", [S3Controller::class, "GeneratePresignedUrl"])->name("s3.presigned-url");
Route::put("/s3/proxy-multipart-upload", [S3Controller::class, "ProxyS3"])->name("s3.proxy");
Route::get("/s3/download", [S3Controller::class, "Download"])->name("s3.download");

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
