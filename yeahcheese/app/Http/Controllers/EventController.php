<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
class EventController extends Controller
{
    public function index(){
        $events = Event::with('pictures')->get();
        return view('events_list', ['events' => $events]);
    }
}
