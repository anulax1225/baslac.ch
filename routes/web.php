<?php

use App\Http\Controllers\PhotoController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\S3Controller;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if(Auth::check()) return redirect(route("photo.index"));
    else return Inertia::render('Home');
})->name('home');

Route::get('/info', function () {
    return Inertia::render('Info');
})->name('info'); 

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/photos', [PhotoController::class, 'index'])->name('photo.index');
    Route::get('/photos/page/{page}', [PhotoController::class, 'pages'])->name('photo.page');
    Route::post('/photo', [PhotoController::class, 'store'])->name('photo.store');
    Route::post('/photos', [PhotoController::class, 'stores'])->name('photo.stores');
    Route::post('/photo/{id}', [PhotoController::class, 'update'])->name('photo.update');
    Route::delete('/photo/{id}', [PhotoController::class, 'destroy'])->name('photo.destroy');
    
    Route::get('/albums', [AlbumController::class, 'index'])->name('album.index');
    Route::get('/albums/page/{page}', [AlbumController::class, 'pages'])->name('album.page');
    Route::get('/album/{id}', [AlbumController::class, 'show'])->name('album.show');
    Route::get('/album/{id}/photos', [AlbumController::class, 'photoUuids'])->name('album.photo.uuid');
    Route::get('/album/{id}/page/{page}', [AlbumController::class, 'photoPages'])->name('album.photo.page');
    Route::delete('/album/{id}/{photoId}', [AlbumController::class, 'photoRemove'])->name('album.photo.remove');
    Route::post('/album', [AlbumController::class, 'store'])->name('album.store');
    Route::post('/album/{id}', [AlbumController::class, 'update'])->name('album.update');
    Route::post('/album/{id}/add', [AlbumController::class, 'addPhotos'])->name('album.add');
    Route::delete('/album/{id}', [AlbumController::class, 'destroy'])->name('album.destroy');

    Route::get('/admin/users', [UserController::class, 'index'])->name("admin.user.index");
    Route::get('/admin/user', [UserController::class, 'create'])->name("admin.user.create");
    Route::post('/admin/user', [UserController::class, 'store'])->name("admin.user.store");
    
    
    Route::get("/s3/start-multipart-upload", [S3Controller::class, "StartMultipartUpload"])->name("s3.multipart.start");
    Route::get("/s3/generate-presigned-multipart-url", [S3Controller::class, "GeneratePresignedMultipartUrl"])->name("s3.multipart.presigned-url");
    Route::post("/s3/complete-multipart-upload", [S3Controller::class, "CompleteMultipartUpload"])->name("s3.multipart.complete");
    Route::get("/s3/generate-presigned-url", [S3Controller::class, "GeneratePresignedUrl"])->name("s3.presigned-url");
    Route::put("/s3/proxy-multipart-upload", [S3Controller::class, "ProxyS3"])->name("s3.proxy");
    Route::get("/s3/download", [S3Controller::class, "Download"])->name("s3.download");

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';
