<?php

use App\Http\Controllers\FCMController;
use App\Http\Controllers\UserApiController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::prefix('user')->group(function () {
//    Route::post('/read', [UserApiController::class, 'postUserRead']);
    Route::post('/register  ', [UserApiController::class, 'postUserRegister']);
    Route::post('/edit', [UserApiController::class, 'postUserEdit']);
    Route::post('/delete', [UserApiController::class, 'postUserDelete']);
    Route::post('/login', [UserApiController::class, 'postUserLogin']);
    Route::post('/logout', [UserApiController::class, 'postUserLogout']);
});



