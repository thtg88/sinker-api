<?php

namespace Tests\Feature\StoreEvent;

use App\Models\Event;
use Illuminate\Http\Response;
use Tests\Feature\TestCase;

class SuccessfulTest extends TestCase
{
    use WithRoute;

    /** @test */
    public function successful_store_response(): void
    {
        $data = Event::factory()->raw();

        $response = $this->loginAs($this->user)
            ->json('post', $this->route(), $data);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'data' => [
                    'path' => $data['path'],
                    'type' => $data['type'],
                ],
            ]);
        $this->assertDatabaseCount('events', 1);
    }

    /** @test */
    public function successful_store_deletes_old_events_from_the_same_path(): void
    {
        $old_event = Event::factory()->forUser($this->user)->create();
        $data = Event::factory()->raw();

        $response = $this->loginAs($this->user)
            ->json('post', $this->route(), $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseCount('events', 1);
    }

    /** @test */
    public function successful_store_creates_a_device_event(): void
    {
        $data = Event::factory()->raw();

        $response = $this->loginAs($this->user)
            ->json('post', $this->route(), $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseCount('device_events', 1);
    }
}
