<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function loginAs(User $user): self
    {
        $headers = [
            config('app.auth_headers.api_key') => $user->api_key,
            config('app.auth_headers.user_id') => $user->uuid,
        ];
        if (!$user->devices->isEmpty()) {
            $headers[config('app.auth_headers.device_id')] = $user->devices->first()->uuid;
        }

        return $this->withHeaders($headers);
    }
}
