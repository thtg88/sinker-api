<?php

use App\Http\Controllers\LatestEventController;
use App\Http\Controllers\Event\StoreController as StoreEventController;
use Illuminate\Support\Facades\Route;

    Route::get('latest', LatestEventController::class)->name('latest');
Route::group(['middleware' => 'auth:api', 'prefix' => 'v1', 'as' => 'v1.'], static function () {
        Route::group(['prefix' => 'events', 'as' => 'events.'], static function () {
            Route::post('/', StoreEventController::class)->name('store');
        });
});
