<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ajax\UserController;

Route::post('register_umum', [UserController::class, 'register_umum'])->name('register_umum');
Route::post('register_pengembang', [UserController::class, 'register_pengembang'])->name('register_pengembang');

Route::group([
    'middleware' => ['auth'],
    'prefix' => 'ajax.user',
    'as' => 'ajax.user.',
], function () {
    // Route::post('/', [UserController::class, 'index'])->name('index');
    Route::put('update/{id}', [UserController::class, 'update'])->name('update');
    Route::put('updatepassword/{id}', [UserController::class, 'updatePassword'])->name('updatepassword');
    Route::delete('delete/{id}', [UserController::class, 'destroy'])->name('delete');
});
