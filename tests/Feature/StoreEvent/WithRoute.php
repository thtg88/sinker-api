<?php

namespace Tests\Feature\StoreEvent;

trait WithRoute
{
    private function route(): string
    {
        return route('api.v1.events.store');
    }
}
