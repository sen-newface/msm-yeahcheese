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

    public function testSuccessDeletePicture()
    {
        $this->seed();
        $picture = Picture::find('1');
        $response = $this->deleteJson('api/pictures/destroy/'. $picture->id);
        
        $this->assertDatabaseMissing('pictures', ['id' => '1']);
        $response->assertStatus(200);
        
    }

    public function testSuccessStorePicture()
    {
        $this->seed();
        $picture = factory(Picture::class)->create();
        //dd($picture->path);
        $response = $this->postJson('api/pictures/store', ['path' => $picture->path]);

        $this->assertDatabaseHas('pictures', [
            'path' => $picture->path
        ]);
        $response->assertStatus(200);
    }
}
