<?php

namespace Tests\Feature\StoreDevice;

trait WithRoute
{
    private function route(): string
    {
        return route('api.v1.devices.store');
    }
}
