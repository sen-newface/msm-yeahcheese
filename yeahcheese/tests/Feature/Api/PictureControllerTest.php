<?php

use App\Picture;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
//use Illuminate\Http\UploadedFile;
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
        //Storage::fake('picture');
        $file = UploadedFile::fake()->image($picture->path);
        $response = $this->json('POST', 'api/pictures/store', [
            'path' => $file,
            'event_id' => $picture->event_id,
        ]);

        $response->assertStatus(200);
        Storage::disk('storage/app/public')->assertExists($file->hashName());
        //Storage::disk('storage/app/public')->assertMissing('missing.jpg');
    }
}
