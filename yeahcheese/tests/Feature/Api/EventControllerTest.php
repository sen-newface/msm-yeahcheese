<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp() : void
    {
        parent::setUp();
        $this->seed();
    }

    public function testSuccessFetch()
    {
        $auth_key = '12345678';

        $response = $this->getJson('api/events/fetch/' . $auth_key);

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'title' => 'テストイベント１',
                'release_date' => '2020-05-12',
                'end_date' => '2020-05-30',
            ]
        ]);
    }
}
