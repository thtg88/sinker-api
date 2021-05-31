<?php

namespace Tests\Feature\StoreDevice;

use App\Models\Device;
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
    }

    /** @test */
    public function successful_store_response(): void
    {
        $data = Device::factory()->raw();

        $response = $this->loginAs($this->user)
            ->json('post', $this->route(), $data);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(['data' => ['uuid']])
            ->assertJson([
                'data' => [
                    'name' => $data['name'],
                ],
            ]);
        $this->assertDatabaseCount('devices', 1);
    }
}
