<?php

use App\Http\Controllers\Ajax\KriteriaController;
use App\Http\Controllers\Ajax\PerumahanController;
use App\Http\Controllers\Ajax\SubKriteriaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ajax\UserController;

Route::post('register_umum', [UserController::class, 'register_umum'])->name('register_umum');
Route::post('register_pengembang', [UserController::class, 'register_pengembang'])->name('register_pengembang');

Route::group([
    'middleware' => ['auth'],
    'prefix' => 'ajax.user',
    'as' => 'ajax.user.',
], function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('pengembang', [UserController::class, 'pengembang'])->name('pengembang');
    Route::put('update/{id}', [UserController::class, 'update'])->name('update');
    Route::put('updatepassword/{id}', [UserController::class, 'updatePassword'])->name('updatepassword');
    Route::get('active_nonactive/{id}', [UserController::class, 'active_nonactive'])->name('active_nonactive');
    Route::delete('delete/{id}', [UserController::class, 'destroy'])->name('delete');
});

Route::group([
    'middleware' => ['auth'],
    'prefix' => 'ajax.kriteria',
    'as' => 'ajax.kriteria.',
], function () {
    Route::get('/', [KriteriaController::class, 'index'])->name('index');
    Route::post('store', [KriteriaController::class, 'store'])->name('store');
    Route::put('update/{id}', [KriteriaController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [KriteriaController::class, 'destroy'])->name('delete');
});

Route::group([
    'middleware' => ['auth'],
    'prefix' => 'ajax.subkriteria',
    'as' => 'ajax.subkriteria.',
], function () {
    Route::get('/', [SubKriteriaController::class, 'index'])->name('index');
    Route::get('data_by_kriteria/{id_kriteria}', [SubKriteriaController::class, 'data_by_kriteria'])->name('data_by_kriteria');
    Route::post('store', [SubKriteriaController::class, 'store'])->name('store');
    Route::put('update/{id}', [SubKriteriaController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [SubKriteriaController::class, 'destroy'])->name('delete');
});

Route::group([
    'middleware' => ['auth', 'role:Pengembang'],
    'prefix' => 'ajax.proyekperumahan',
    'as' => 'ajax.proyekperumahan.',
], function () {
    Route::get('/', [PerumahanController::class, 'index'])->name('index');
    Route::post('store', [PerumahanController::class, 'store'])->name('store');
    Route::put('update/{id}', [PerumahanController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [PerumahanController::class, 'destroy'])->name('delete');
});
