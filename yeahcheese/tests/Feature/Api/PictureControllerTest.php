<?php

use App\Picture;
//use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithoutMiddleware;
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

    public function testSuccessStorePicture()
    {
        $this->seed();
        $picture = factory(Picture::class)->create();
        Storage::fake('picture');
        $file = UploadedFile::fake()->image($picture->path);
        //dd($picture);
        $response = $this->json('POST', 'api/pictures/store', [
            'file' => $file,
            'event_id' => $picture->event_id,
        ]);

        $response->assertStatus(201);
        Storage::disk('storage/app/public')->assertExists($file->hashName());
        //Storage::disk('storage/app/public')->assertMissing('missing.jpg');
    }
}
