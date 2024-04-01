<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [UserController::class, 'detail'])->name('detail.admin.user');
Route::get('/admin/login', [AdminController::class, 'admin'])->name('admin');
Route::post('/admin', [AdminController::class, 'login'])->name('admin.login');
Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::group(['middleware' => 'disable_back_btn'], function () {
    Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'],
        function () {
            Route::get('/users/list', [UserController::class, 'displayusers'])->name('displayusers');
            Route::get('/form', [UserController::class, 'form'])->name('form');
            Route::get('/edit/{id?}', [UserController::class, 'edit'])->name('edit');
            Route::get('/delete/{id}', [UserController::class, 'delete'])->name('delete');
            Route::post('/user/save', [UserController::class, 'save'])->name('user.save');
            Route::get('/user-list', [UserController::class, 'userlist'])->name('user.list');
        });
    Route::group(['prefix' => 'user', 'middleware' => 'auth:user'],
        function () {
            Route::get('/list', [UserAuthController::class, 'userlist'])->name('users.list');
        });
});

Route::prefix('user')->group(function () {
    Route::get('/login', [UserAuthController::class, 'user'])->name('user');
    Route::get('/logout', [UserAuthController::class, 'logout'])->name('user.logout');
    Route::post('/loginuser', [UserAuthController::class, 'loginuser'])->name('user.login');
    Route::get('/register', [UserAuthController::class, 'register'])->name('user.register');
    Route::post('/store', [UserAuthController::class, 'store'])->name('user.store');
});

Route::get('/google/login', [UserAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/google/callback', [UserAuthController::class, 'handleGoogleCallback'])->name('google.callback');

Route::prefix('firebase')->group(function () {
    Route::get('', [HomeController::class, 'index']);
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
    Route::post('/chat/join', [ChatController::class, 'join'])->name('chat.join');
});


