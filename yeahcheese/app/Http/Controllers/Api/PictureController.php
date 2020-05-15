<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Picture;

class PictureController extends Controller
{
    public function fetch(Picture $picture)
    {
        # code...
    }

    public function store(Request $request)
    {
        // 画像を保存
        $path = \Storage::putFile('public', $request->file);
        // DBに保存
        Picture::create(['path' => $path]);
        // fetchに返す
        return;
    }

    public function destroy(Picture $picture)
    {
        # code...
    }
}
