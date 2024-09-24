<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::get('/', function () { return view('home'); });

Route::get("/albums", [AlbumController::class, "index"]);
Route::get("/albums/{id}", [AlbumController::class, "show"]);
Route::post("/albums", [AlbumController::class, "store"]);
Route::put("/albums/{id}", [AlbumController::class, "update"]);
Route::delete("/albums/{id}", [AlbumController::class, "destroy"]);

Route::get("/article", [ArticleController::class, "index"]);
Route::get("/article/{id}", [ArticleController::class, "show"]);
Route::post("/article", [ArticleController::class, "store"]);
Route::put("/article/{id}", [ArticleController::class, "update"]);
Route::delete("/article/{id}", [ArticleController::class, "destroy"]);

Route::get("/categories", [CategorieController::class, "index"]);
Route::get("/categories/{id}", [CategorieController::class, "show"]);
Route::post("/categories", [CategorieController::class, "store"]);
Route::put("/categories/{id}", [CategorieController::class, "update"]);
Route::delete("/categories/{id}", [CategorieController::class, "destroy"]);

Route::get("/users", [UserController::class, "index"]);
Route::get("/users/{id}", [UserController::class, "show"]);
Route::post("/users", [UserController::class, "store"]);
Route::put("/users/{id}", [UserController::class, "update"]);
Route::delete("/users/{id}", [UserController::class, "destroy"]);

Route::get("/infos", [InfoController::class, "index"]);
Route::get("/infos/{id}", [InfoController::class, "show"]);
Route::post("/infos", [InfoController::class, "store"]);
Route::put("/infos/{id}", [InfoController::class, "update"]);
Route::delete("/infos/{id}", [InfoController::class, "destroy"]);

Route::post("/images", [ImageController::class, "store"]);
Route::delete("/images/{id}", [ImageController::class, "destroy"]);