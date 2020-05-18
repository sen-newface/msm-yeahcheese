<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PictureControllerTest extends TestCase
{
    use RefreshDatabase;

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
