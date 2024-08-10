<?php

declare(strict_types=1);

use App\Http\Controllers\V1\ComicsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'as' => 'api.v1.'], function () {
    Route::group(['prefix' => 'comics', 'as' => 'comics.'], function () {
        Route::get('/', [ComicsController::class, 'index'])->name('index');
        Route::get('/{comicId}', [ComicsController::class, 'show'])->name('show');
        Route::post('/', [ComicsController::class, 'store'])->name('store');
        Route::put('{comicId}', [ComicsController::class, 'update'])->name('update');
        Route::delete('{comicId}', [ComicsController::class, 'destroy'])->name('destroy');
    });
});
