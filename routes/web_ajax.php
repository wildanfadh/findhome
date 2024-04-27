<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ajax\UserController;

Route::post('register_umum', [UserController::class, 'register_umum'])->name('register_umum');
Route::post('register_penegmbang', [UserController::class, 'register_penegmbang'])->name('register_penegmbang');

Route::group([
    'middleware' => ['auth', 'role:Superadmin'],
    'prefix' => 'ajax.user',
    'as' => 'ajax.user.',
], function () {
    // Route::post('/', [UserController::class, 'index'])->name('index');
    Route::put('update/{id}', [UserController::class, 'update'])->name('update');
    Route::put('updatepassword/{id}', [UserController::class, 'updatePassword'])->name('updatepassword');
    Route::delete('delete/{id}', [UserController::class, 'destroy'])->name('delete');
});
