<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;
use App\Http\Requests\UpdateEventRequest;

use App\Http\Resources\EventResources;

class EventController extends Controller
{
    public function fetch($id)
    {
        $event = Event::find($id);
        return new EventResources($event);
    }

    public function update(UpdateEventRequest $request)
    {
        if (!$request->has('id')) {
            abort(response()->json(['messages' => ['IDが見つかりませんでした']]));
        }

        $event = Event::find($request->id);

        if (!is_null($event)) {
            $event->fill($request->all())->save();
            return new EventResources($event);
        }
    }
}
