<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function show(Request $request) //resquestに認証キー
    {
        $event = \App\Event::where('auth_key', $request)->get();
        $picture = \App\Picture::where('event_id', $event->id)->get();
        $data = [['pictures' => $picture], ['event' => $event]];
        return view('event', $data);
    }
}
