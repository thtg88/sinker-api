<?php

namespace Tests\Feature\Event\Latest;

trait WithRoute
{
    private function route($timestamp): string
    {
        return route('api.v1.events.latest', ['t' => $timestamp]);
    }
}
