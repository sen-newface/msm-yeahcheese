<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;

use App\Http\Resources\EventResources;

class EventController extends Controller
{
    public function fetch(Event $event)
    {
        return new EventResource($event);
    }

    public function update(Event $event)
    {
        #
    }
}
