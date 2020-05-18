<?php

use App\Picture;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PictureControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessGetPathList()
    {
        $this->seed();
        $response = $this->getJson('api/pictures/list');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                ['path' => 'neko_magazine04.jpg'],
                ['path' => 'neko_magazine04.jpg'],
                ['path' => 'neko_magazine04.jpg'],
            ]
        ]);
    }

    public function testSuccessGetPath()
    {
        $this->seed();
        $picture = Picture::find('1');
        $response = $this->getJson('api/pictures/fetch/' . $picture->id);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                ['path' => 'neko_magazine04.jpg'],
            ]
        ]);
    }

    public function testSuccessDeletePicture()
    {
        $this->seed();
        $picture = Picture::find('1');
        $response = $this->deleteJson('api/pictures/destroy/'. $picture->id);

        $this->assertDatabaseMissing('pictures', ['id' => '1']);
        $response->assertStatus(200);
    }
}
