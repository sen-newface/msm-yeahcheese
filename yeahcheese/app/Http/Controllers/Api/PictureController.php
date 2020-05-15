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
        // 保存されたら編集画面に画像を表示するので
        // イベント編集画面をリダイレクト
        // イベント編集画面のrouteがupdate
        return redirect()->route('events.update');
    }

    public function destroy(Picture $picture)
    {
        # code...
    }
}
