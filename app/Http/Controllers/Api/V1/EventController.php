<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        return Event::paginate($perPage);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'parentEventID' => ['nullable'],
            'eventDate' => ['nullable'],
            'eventTime' => ['nullable'],
            'year' => ['nullable'],
            'month' => ['nullable'],
            'day' => ['nullable'],
            'habitat' => ['nullable'],
            'samplingProtocol' => ['nullable'],
            'fieldNotes' => ['nullable'],
            'locationID' => ['nullable'],
            'eventRemarks' => ['nullable']
        ]);
        $item = Event::create($data);
        return response()->json($item, 201);
    }

    public function show(Event $event)
    {
        return $event;
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->all();
        $event->update($data);
        return $event;
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return response()->noContent();
    }
}
