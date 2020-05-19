<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PictureResources;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Picture;

class PictureController extends Controller
{
    public function list()
    {
        $picture = Picture::all();
        return PictureResources::Collection($picture);
    }

    public function fetch(Picture $picture)
    {
        # code...
    }

    public function store(Request $request)
    {
        // $requestにファイル, ファイル名, event_idが含まれる
        // 画像を保存
        $path = Storage::putFile('public', $request->file);
        // DBに保存
        $picture = Picture::create(['path' => $path, 'event_id' => $request->event_id]);
        // fetchに返す
        return PictureResources::collection($picture);
    }

    public function destroy($picture_id)
    {
        Picture::where('id', $picture_id)->delete();
    }
}
