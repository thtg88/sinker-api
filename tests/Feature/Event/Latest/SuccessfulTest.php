<?php

namespace Tests\Feature\Event\Latest;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\Feature\TestCase;

class SuccessfulTest extends TestCase
{
    use WithRoute;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->user->devices()->orderBy('id')->create();
    }

    /** @test */
    public function successful_latest_response(): void
    {
        // Create an event that I have not emitted from the current device
        $device = $this->user->devices()->create();
        $event = Event::factory()->forUser($this->user)->create();

        $response = $this->loginAs($this->user)
            ->json('get', $this->route(time() - 100));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'data' => [[
                    'id' => $event->id,
                    'path' => $event->path,
                    'type' => $event->type,
                ]],
            ]);
    }
}
