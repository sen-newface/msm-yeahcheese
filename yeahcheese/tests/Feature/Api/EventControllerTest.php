<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Event;

class EventControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testSuccessFetch()
    {
        $event = factory(Event::class)->create();

        $response = $this->getJson('api/events/fetch/' . $event->auth_key);

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'title' => $event->title,
                'release_date' => $event->release_date,
                'end_date' => $event->end_date,
            ]
        ]);
    }

    public function testSuccessUpdate()
    {
        $event = factory(Event::class)->create();

        $request = [
            'id' => $event->id,
            'title' => 'update event title',
            'release_date' => '2020-06-01',
            'end_date' => '2020-06-30',
        ];

        $response = $this->put('api/events/update', $request);

        $response->assertStatus(200);

        $this->assertDatabaseHas('events', ['title' => $request->title]);
    }
}
