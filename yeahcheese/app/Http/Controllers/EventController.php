<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Event;
use \App\Picture;

class EventController extends Controller
{
  
    public function index()
    {
        $events = Event::with('pictures')->get();
        return view('events_list', ['events' => $events]);
    }
  
    // TODO: resquestに認証キー
    public function show(Request $request)
    {
        $event = Event::where('auth_key', $request->auth)->get();
        $picture = Picture::where('event_id', $event->id)->get();
        $data = [['pictures' => $picture], ['event' => $event]];
        return view('event', $data);
    }
}