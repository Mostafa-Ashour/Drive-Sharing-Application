<?php

use App\Http\Controllers\Api\DriveApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('drives/')->group(function () {
        Route::get('', [DriveApiController::class, 'index']);
        Route::post('', [DriveApiController::class, 'store']);
        Route::get('{id}', [DriveApiController::class, 'show']);
        Route::post('{id}', [DriveApiController::class, 'update']);
        Route::delete('{id}', [DriveApiController::class, 'destroy']);
    });
    Route::get('/logout', [UserApiController::class, 'logout']);
});

Route::post('/register', [UserApiController::class, 'register']);
Route::post('/login', [UserApiController::class, 'login']);
