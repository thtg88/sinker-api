<?php

namespace Tests\Feature\StoreEvent;

trait WithRoute
{
    private function route(): string
    {
        return route('events.store');
    }
}
