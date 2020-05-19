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

        $actual = [
            'id' => $event->id,
            'title' => Event::find($event->id)->title,
            'release_date' => Event::find($event->id)->release_date,
            'end_date' => Event::find($event->id)->end_date,
        ];

        $this->assertEquals($request, $actual);
    }

    public function testSuccessUpdateTitle()
    {
        $event = factory(Event::class)->create();

        $request = [
            'id' => $event->id,
            'title' => 'update event title',
        ];

        $response = $this->put('api/events/update', $request);

        $response->assertStatus(200);

        $actual = [
            'id' => $event->id,
            'title' => Event::find($event->id)->title,
        ];

        $this->assertEquals($request, $actual);
    }

    public function testSuccessUpdateReleaseDate()
    {
        $event = factory(Event::class)->create();

        $request = [
            'id' => $event->id,
            'release_date' => '2020-06-01',
        ];

        $response = $this->put('api/events/update', $request);

        $response->assertStatus(200);

        $actual = [
            'id' => $event->id,
            'release_date' => Event::find($event->id)->release_date,
        ];

        $this->assertEquals($request, $actual);
    }

    public function testSuccessUpdateEndDate()
    {
        $event = factory(Event::class)->create();

        $request = [
            'id' => $event->id,
            'end_date' => '2020-06-30',
        ];

        $response = $this->put('api/events/update', $request);

        $response->assertStatus(200);

        $actual = [
            'id' => $event->id,
            'end_date' => Event::find($event->id)->end_date,
        ];

        $this->assertEquals($request, $actual);
    }
}
