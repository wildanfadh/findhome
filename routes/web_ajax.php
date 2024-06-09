<?php

use App\Http\Controllers\Ajax\KriteriaController;
use App\Http\Controllers\Ajax\KuesionerController;
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
    'middleware' => ['auth'],
    'prefix' => 'ajax.proyekperumahan',
    'as' => 'ajax.proyekperumahan.',
], function () {
    Route::get('/', [PerumahanController::class, 'index'])->name('index');
    Route::get('perumahan_by_pengembang', [PerumahanController::class, 'perumahanByPengembang'])->name('perumahan_by_pengembang');
    Route::post('store', [PerumahanController::class, 'store'])->name('store')->middleware('pengembang');
    Route::put('update/{id}', [PerumahanController::class, 'update'])->name('update')->middleware('pengembang');
    Route::post('request_kriteria_perumahan', [PerumahanController::class, 'request_kriteria_perumahan'])->name('request_kriteria_perumahan');
    Route::delete('delete/{id}', [PerumahanController::class, 'destroy'])->name('delete');
});


Route::group([
    'middleware' => ['auth'],
    'prefix' => 'ajax.kuesioner',
    'as' => 'ajax.kuesioner.',
], function () {
    Route::get('/', [KuesionerController::class, 'index'])->name('index');
    Route::get('hitung_bobot_kuesioner', [KuesionerController::class, 'hitung_bobot_kuesioner'])->name('hitung_bobot_kuesioner');
});
