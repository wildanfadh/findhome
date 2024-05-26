<?php

use App\Http\Controllers\Pages\KriteriaController;
use App\Http\Controllers\Pages\PerumahanController;
use App\Http\Controllers\Pages\RekomendasiController;
use App\Http\Controllers\Pages\SubKriteriaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pages\UserController;
use App\Http\Controllers\Pages\VerifikasiController;

Route::group([
    // 'middleware' => ['auth'],
    'prefix' => 'page.user',
    'as' => 'page.user.',
], function () {
    Route::get('index', [UserController::class, 'index'])->name('index')->middleware('admin');
    Route::get('pengembang', [UserController::class, 'pengembang'])->name('pengembang')->middleware('admin');
    Route::get('register_pengembang', [UserController::class, 'register_pengembang'])->name('register_pengembang');
    Route::get('myprofile', [UserController::class, 'myprofile'])->name('myprofile')->middleware('auth');
});

Route::group([
    'middleware' => ['auth'],
    'prefix' => 'page.perumahan',
    'as' => 'page.perumahan.',
], function () {
    Route::get('list', [PerumahanController::class, 'list_perumahan'])->name('list');
    Route::get('proyek', [PerumahanController::class, 'proyek_perumahan'])->name('proyek')->middleware('pengembang');
    Route::get('detail/{id}', [PerumahanController::class, 'detail_perumahan'])->name('detail');
    Route::get('detail_kriteria/{id}', [PerumahanController::class, 'detail_perumahan_kriteria'])->name('detail_kriteria');
});

Route::group([
    'middleware' => ['auth'],
    'prefix' => 'page.uji',
    'as' => 'page.uji.',
], function () {
    Route::get('rekomendasi', [RekomendasiController::class, 'rekomendasi'])->name('rekomendasi');
    Route::get('preferensi', [RekomendasiController::class, 'preferensi'])->name('preferensi')->middleware('umum');
    Route::get('rekomendasi_preferensi', [RekomendasiController::class, 'rekomendasi_preferensi'])->name('rekomendasi_preferensi')->middleware('umum');
});

Route::group([
    'middleware' => ['auth', 'role:Admin'],
    'prefix' => 'page.verifikasi',
    'as' => 'page.verifikasi.',
], function () {
    Route::get('index', [VerifikasiController::class, 'index'])->name('index');
});

Route::group([
    'middleware' => ['auth', 'role:Admin'],
    'prefix' => 'page.kriteria',
    'as' => 'page.kriteria.',
], function () {
    Route::get('index', [KriteriaController::class, 'index'])->name('index');
});

Route::group([
    'middleware' => ['auth', 'role:Admin'],
    'prefix' => 'page.subkriteria',
    'as' => 'page.subkriteria.',
], function () {
    Route::get('index', [SubKriteriaController::class, 'index'])->name('index');
    Route::get('list_by_kriteria/{kriteria_id}', [SubKriteriaController::class, 'list_by_kriteria'])->name('list_by_kriteria');
});
