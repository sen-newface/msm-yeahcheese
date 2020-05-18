<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use UsersTableSeeder;
use EventsTableSeeder;
use PicturesTableSeeder;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp() : void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testSuccessFetch()
    {
        $request = ['auth_key' => '12345678'];

        $response = $this->getJson('api/events/fetch', $request);

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                'title' => 'テストイベント１',
                'release_date' => '2020-05-12',
                'end_date' => '2020-05-30',
                'auth_key' => '12345678',
                'user_id' => 1,
            ]
        ]);
    }
}
