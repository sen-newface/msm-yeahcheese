<?php

use App\Picture;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PictureControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testSuccessGetPathList()
    {

        $data = [];

        $pictures = Picture::All();

        foreach($pictures as $picture) {
            $data[] = ['path' => $picture->path];
        }

        $expect = ['data'=>$data];

        $response = $this->getJson('api/pictures/list');

        $response->assertStatus(200);

        $response->assertJson($expect);
    }

    public function testSuccessGetPath()
    {
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
        $picture = Picture::find('1');
        $response = $this->deleteJson('api/pictures/destroy/'. $picture->id);

        $this->assertDatabaseMissing('pictures', ['id' => '1']);
        $response->assertStatus(200);
    }
}
