<?php

use App\Http\Controllers\Pages\PerumahanController;
use App\Http\Controllers\Pages\RekomendasiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pages\UserController;

Route::group([
    'prefix' => 'page.user',
    'as' => 'page.user.',
], function () {
    Route::get('register_pengembang', [UserController::class, 'register_pengembang'])->name('register_pengembang');
});


Route::group([
    'prefix' => 'page.perumahan',
    'as' => 'page.perumahan.',
], function () {
    Route::get('list', [PerumahanController::class, 'list_pengembang'])->name('list');
    Route::get('detail/{id}', [PerumahanController::class, 'detail_pengembang'])->name('detail');
});

Route::group([
    'prefix' => 'page.uji',
    'as' => 'page.uji.',
], function () {
    Route::get('rekomendasi', [RekomendasiController::class, 'rekomendasi'])->name('rekomendasi');
    Route::get('preference', [RekomendasiController::class, 'preference'])->name('preference');
});
