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
            'title' => '96y82AhDHF4ghuzFUsVbeFxEsiQTPGikPSGWwMeiJhDxaGBD2YsfCRN3txBJPGKf986WLGAAj5arsN6eTX8KWtnFaM96i5FUiV5nYrcWpVtiynMGnPa9bm684UJ4YnSmcJ4iWZxEAZUkz8m38fEGyxYZHkLc7butrB4EaxTrPRKcbCTwYSfTVjZ2NuAQmuRwWaas9xT5hBMQ3rr3FG2JBWjhDPKKyiEu68eW5EuscF6ynBB6HxuKGub9LgDiMmeNhue4JjXgXwZ5Ca9yzj8NXep2mxG9PGmj59arQRWnjJbW',
            'release_date' => strtotime('+7 day' . $event->end_date),
            'end_date' => $event->end_date,
        ];

        $response = $this->put('api/events/update', $request);

        $response->assertStatus(200);

        $response->assertJson([
            'messages' => [
                'イベントタイトルは255文字まで設定できます',
                'イベント公開開始日は公開終了日より前の日付である必要があります',
            ]
        ]);
    }

    public function testDenyInvalidTitle()
    {
        $event = factory(Event::class)->create();

        $request = [
            'id' => $event->id,
            'title' => '96y82AhDHF4ghuzFUsVbeFxEsiQTPGikPSGWwMeiJhDxaGBD2YsfCRN3txBJPGKf986WLGAAj5arsN6eTX8KWtnFaM96i5FUiV5nYrcWpVtiynMGnPa9bm684UJ4YnSmcJ4iWZxEAZUkz8m38fEGyxYZHkLc7butrB4EaxTrPRKcbCTwYSfTVjZ2NuAQmuRwWaas9xT5hBMQ3rr3FG2JBWjhDPKKyiEu68eW5EuscF6ynBB6HxuKGub9LgDiMmeNhue4JjXgXwZ5Ca9yzj8NXep2mxG9PGmj59arQRWnjJbW',
        ];

        $response = $this->put('api/events/update', $request);

        $response->assertStatus(200);

        $response->assertJson([
            'messages' => [
                'イベントタイトルは255文字まで設定できます',
            ]
        ]);
    }

    public function testDenyInvalidReleaseDate()
    {
        $event = factory(Event::class)->create();

        $request = [
            'id' => $event->id,
            'release_date' => strtotime('+7 day' . $event->end_date),
        ];

        $response = $this->put('api/events/update', $request);

        $response->assertStatus(200);

        $response->assertJson([
            'messages' => [
                'イベント公開開始日は公開終了日より前の日付である必要があります',
            ]
        ]);
    }

    public function testDenyInvalidEndDate()
    {
        $event = factory(Event::class)->create();

        $request = [
            'id' => $event->id,
            'end_date' => strtotime('-7 day' . $event->release_date),
        ];

        $response = $this->put('api/events/update', $request);

        $response->assertStatus(200);

        $response->assertJson([
            'messages' => [
                'イベント公開終了日はイベント公開開始日より後の日付である必要があります',
            ]
        ]);
    }
}
