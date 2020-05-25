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

        $response = $this->getJson('api/events/fetch/' . $event->id);

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
            'release_date' => (new DateTime($event->release_date))->modify('+1 day')->format('Y-m-d H:i'),
            'end_date' => (new DateTime($event->release_date))->modify('+7 days')->format('Y-m-d H:i'),
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

    public function testDenyUpdateRequestWithoutId()
    {
        $request = [
            'title' => 'update event title',
            'release_date' => '2020-06-01',
            'end_date' => '2020-06-30',
        ];

        $response = $this->put('api/events/update', $request);

        $response->assertStatus(200);

        $response->assertJson([
            'messages' => [
                'IDが見つかりませんでした'
            ]
        ]);
    }

    public function testDenyInvalidUpdateRequest()
    {
        $event = factory(Event::class)->create();

        $request = [
            'id' => $event->id,
            'title' => str_repeat('a', 256),
            'release_date' => (new DateTime($event->end_date))->modify('+7 day')->format('Y-m-d H:i'),
            'end_date' => $event->end_date,
        ];

        $response = $this->put('api/events/update', $request);

        $response->assertStatus(200);

        $response->assertJson([
            'messages' => [
                'title' => ['イベントタイトルは255文字まで設定できます'],
                'release_date' => ['イベント公開開始日は公開終了日より前の日付である必要があります'],
            ]
        ]);
    }

    public function testDenyInvalidTitle()
    {
        $event = factory(Event::class)->create();

        $request = [
            'id' => $event->id,
            'title' => str_repeat('a', 256),
            'release_date' => $event->release_date,
            'end_date' => $event->end_date,
        ];

        $response = $this->put('api/events/update', $request);

        $response->assertStatus(200);

        $response->assertJson([
            'messages' => [
                'title' => ['イベントタイトルは255文字まで設定できます'],
            ]
        ]);
    }

    public function testDenyInvalidReleaseDate()
    {
        $event = factory(Event::class)->create();

        $request = [
            'id' => $event->id,
            'title' => $event->title,
            'release_date' => (new DateTime($event->end_date))->modify('+7 day')->format('Y-m-d H:i'),
            'end_date' => $event->end_date,
        ];

        $response = $this->put('api/events/update', $request);

        $response->assertStatus(200);

        $response->assertJson([
            'messages' => [
                'release_date' => ['イベント公開開始日は公開終了日より前の日付である必要があります'],
            ]
        ]);
    }

    public function testDenyInvalidEndDate()
    {
        $event = factory(Event::class)->create();

        $request = [
            'id' => $event->id,
            'title' => $event->title,
            'release_date' => $event->release_date,
            'end_date' => (new DateTime($event->release_date))->modify('-7 days')->format('Y-m-d H:i'),
        ];

        $response = $this->put('api/events/update', $request);

        $response->assertStatus(200);

        $response->assertJson([
            'messages' => [
                'end_date' => ['イベント公開終了日はイベント公開開始日より後の日付である必要があります'],
            ]
        ]);
    }
}
