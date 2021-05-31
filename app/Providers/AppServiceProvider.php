<?php

namespace App\Providers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Request::macro('device', function () {
            /** @var \Illuminate\Http\Request $this */
            if (!$this->user()) {
                return null;
            }

            return Device::query()
                ->where('uuid', $this->deviceId())
                ->where('user_id', $this->user()->id)
                ->first();
        });
        Request::macro('deviceId', function () {
            /** @var \Illuminate\Http\Request $this */
            return $this->header(config('app.auth_headers.device_id'));
        });
        Request::macro('apiKey', function () {
            /** @var \Illuminate\Http\Request $this */
            return $this->header(config('app.auth_headers.api_key'));
        });
        Request::macro('userId', function () {
            /** @var \Illuminate\Http\Request $this */
            return $this->header(config('app.auth_headers.user_id'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
