<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatApiController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, "register"]);
Route::post('/login', [AuthController::class, "login"]);

Route::prefix('en')->group(function () {
    Route::get("/cats", [CatApiController::class, "getAllEnglish"]);
    Route::get("/cats/{id}", [CatApiController::class, "getEnglish"]);
});

Route::prefix('nl')->group(function () {
    Route::get("/cats", [CatApiController::class, "getAllDutch"]);
    Route::get("/cats/{id}", [CatApiController::class, "getDutch"]);
});

// Get both languages
Route::get("/cats/{id}", [CatApiController::class, "get"]);
Route::get("/cats", [CatApiController::class, "getAll"]);

Route::middleware('auth:api')->group(function () {
    // Create, update and delete is done in both languages
    Route::post('/cats', [CatApiController::class, "create"]);
    Route::put('/cats/{id}', [CatApiController::class, "update"]);
    Route::delete('/cats/{id}', [CatApiController::class, "delete"]);
});
