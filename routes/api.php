<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserPostController;
use App\Http\Controllers\Api\ArchiveController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get("/test", function () {
    return "Server is running";
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/archive', [ArchiveController::class, 'create']);
    Route::get('/archive/all', [ArchiveController::class, 'index']);

    Route::post('/post', [UserPostController::class, 'create']);
    Route::get('/post/all', [UserPostController::class,'getAll']);
    Route::get('/post/search', [UserPostController::class, 'search']);
    Route::post('/post/like/{id}', [UserPostController::class, 'like']);
    Route::post('/post/unlike/{id}', [UserPostController::class, 'unLike']);
    Route::post('/post/my-post', [UserPostController::class, 'getMyPost']);
});
