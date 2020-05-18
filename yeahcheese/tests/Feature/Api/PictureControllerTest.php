<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PicturesTableSeeder;
use EventsTableSeeder;
use UsersTableSeeder;

class PictureControllerTest extends TestCase
{
    use RefreshDatabase;

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

    public function testSuccessIndex()
    {
        $this->seed();
        $response = $this->getJson('api/pictures/index');

        $response->assertStatus(200);
        
        $response->assertJson([
            'data' => [
                ['path' => 'neko_magazine04.jpg'],
                ['path' => 'neko_magazine04.jpg'],
                ['path' => 'neko_magazine04.jpg'],
            ]
        ]);
    }
}
