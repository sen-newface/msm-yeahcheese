<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Picture;

use App\Http\Resources\PictureResources;

class PictureController extends Controller
{
    public function list()
    {
        $picture = Picture::all();
        return PictureResources::Collection($picture);
    }

    public function fetch(int $picture_id)
    {
        $picture = Picture::where('id', $picture_id)
            ->get();
        return PictureResources::Collection($picture);
    }

    public function store(Request $request)
    {
        # code...
    }

    public function destroy(int $picture_id)
    {
        Picture::where('id', $picture_id)->delete();
    }
}
