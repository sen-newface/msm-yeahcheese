<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StorePictureRequest;
use App\Picture;

use App\Http\Resources\PictureResources;

class PictureController extends Controller
{
    public function list(int $event_id)
    {
        $pictures = Picture::where('event_id', $event_id)
            ->get();
        return PictureResources::Collection($pictures);
    }

    public function fetch(int $picture_id)
    {
        $picture = Picture::where('id', $picture_id)
            ->get();
        return PictureResources::Collection($picture);
    }

    public function store(StorePictureRequest $request)
    {
        // 画像を保存
        $path = Storage::putFile('public', $request->file);
        // DBに保存
        $picture = Picture::create(['path' => $path, 'event_id' => $request->event_id]);
        // 保存したpictureのpathを返す
        return new PictureResources($picture);
    }

    public function destroy(int $picture_id)
    {
        Picture::where('id', $picture_id)->delete();
    }
}
