<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PictureResources;
use Illuminate\Http\Request;
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
        # code...
    }

    public function destroy(Picture $picture)
    {
        # code...
    }
}
