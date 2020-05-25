<?php

use App\Picture;
use App\Event;
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
        $all_pictures = Picture::All();
        $event = Event::find($all_pictures->random()->event_id);

        $response = $this->getJson('api/pictures/list/' . $event->id);

        $pictures = Picture::where('event_id', $event->id)->get();
        $data = [];
        foreach ($pictures as $picture) {
            $data[] = [
                'id' => $picture->id,
                'event_id' => $picture->event_id,
                'path' => $picture->path,
            ];
        }

        $expect = ['data' => $data];

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
        Storage::fake('storage/app/public');
        $file = UploadedFile::fake()->image($picture->path)
            ->size(200);

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

    public function testDenyInvalidStorePictureSizeRequest()
    {
        $picture = factory(Picture::class)->create();
        Storage::fake('storage/app/public');
        /*20000kbなので保存失敗*/
        $file = UploadedFile::fake()->image($picture->path)
            ->size(20000);

        $response = $this->json('POST', 'api/pictures/store', [
            'file' => $file,
            'event_id' => $picture->event_id,
        ]);
        $response->assertStatus(200);

        $response->assertJson([
            'messages' => [
                'file' => ['100KB以上、1MB以下の画像にしてください'],
            ]
        ]);
    }

    public function testDenyInvalidStorePictureMimesRequest()
    {
        $picture = factory(Picture::class)->create();
        /*png形式なので保存失敗*/
        Storage::fake('storage/app/public');
        $file = UploadedFile::fake()->image('testPath.png')
            ->size(200);

        $response = $this->json('POST', 'api/pictures/store', [
            'file' => $file,
            'event_id' => $picture->event_id,
        ]);
        $response->assertStatus(200);

        $response->assertJson([
            'messages' => [
                'file' => ['jpgまたはjpeg形式にしてください'],
            ]
        ]);
    }
}
