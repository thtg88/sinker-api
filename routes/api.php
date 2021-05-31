<?php

use App\Http\Controllers\Device\StoreController as StoreDeviceController;
use App\Http\Controllers\Event\StoreController as StoreEventController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api', 'prefix' => 'v1', 'as' => 'v1.'], static function () {
    Route::post('devices', StoreDeviceController::class)
        ->middleware('throttle:store_device')
        ->name('devices.store');

    Route::group(['middleware' => 'authorize_device'], static function () {
        Route::group(['prefix' => 'events', 'as' => 'events.'], static function () {
            Route::post('/', StoreEventController::class)->name('store');
        });
    });
});
