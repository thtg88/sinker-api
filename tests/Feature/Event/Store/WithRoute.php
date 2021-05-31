<?php

namespace Tests\Feature\Event\Store;

trait WithRoute
{
    private function route(): string
    {
        return route('api.v1.events.store');
    }
}
