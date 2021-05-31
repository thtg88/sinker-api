<?php

use App\Http\Controllers\LatestEventController;
use App\Http\Controllers\StoreEventController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api', 'prefix' => 'events', 'as' => 'events.'], static function () {
    Route::get('latest', LatestEventController::class)->name('latest');
    Route::post('/', StoreEventController::class)->name('store');
});
