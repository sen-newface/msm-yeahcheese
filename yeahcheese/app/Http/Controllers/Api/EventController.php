<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;

use App\Http\Resources\EventResources;

class EventController extends Controller
{
    public function fetch($auth_key)
    {
        $event = Event::AuthKeyEquals($auth_key)->first();
        return new EventResources($event);
    }

    public function update(Event $event)
    {
        #
    }
}
