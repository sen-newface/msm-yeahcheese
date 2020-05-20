<?php

use App\Picture;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
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
        $picture = factory(Picture::class)->create();

        $response = $this->getJson('api/pictures/fetch/' . $picture->id);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                ['path' => $picture->path],
            ]
        ]);
    }

    public function testSuccessDeletePicture()
    {
        $picture = factory(Picture::class)->create();
        $response = $this->deleteJson('api/pictures/destroy/'. $picture->id);

        $this->assertDatabaseMissing('pictures', ['id' => $picture->id]);
        $response->assertStatus(200);
    }

    public function testSuccessStorePicture()
    {
        $picture = factory(Picture::class)->create();
        Storage::fake('picture');
        $file = UploadedFile::fake()->image($picture->path);
        
        $response = $this->json('POST', 'api/pictures/store', [
            'file' => $file,
            'event_id' => $picture->event_id,
        ]);
        $response->assertStatus(201);

        $this->assertDatabaseHas('pictures', [
            'id' => $picture->id,
        ]);

        Storage::disk('public')->assertExists($file->hashName());
    }
}
