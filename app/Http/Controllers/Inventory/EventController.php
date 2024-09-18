<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{

    public function index()
    {
        $events = Event::paginate(10);

        return view('inventory.events', [
            'events' => $events
        ]);
    }

    public function viewEvent($eventID)
    {
        $event = Event::findOrFail($eventID);

        return view('inventory.event', [
            'event' => $event
        ]);
    }

    public function deleteEvent($eventID)
    {
        try {
            DB::beginTransaction();

            Event::findOrFail($eventID)
                ->delete();

            DB::commit();

            return redirect()->back()->with(['message' => 'Event Deleted!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function updateEvent(Request $request, $eventID)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'title' => 'required|string',
                'image' => 'required',
                'description' => 'required|string',
                'location' => 'required|string',
                'start' => 'required|date',
                'end' => 'required|date',
            ]);

            Event::findOrFail($eventID)->update($validated);

            DB::commit();

            return redirect()->back()->with(['message' => 'Event updated!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function newEvent(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'title' => 'required|string',
                'image' => 'required',
                'description' => 'required|string',
                'location' => 'required|string',
                'start' => 'required|date',
                'end' => 'required|date',
            ]);

            $event  = new Event();

            $event->fill($validated);

            $event->image = null;

            if($request->file('image')){

                $filename = $request->file('image')->store('public');

                if($filename){
                   $event->image = $filename;
                }

            }

            $event->save();

            DB::commit();

            return redirect()->back()->with(['message' => 'Event Added!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }
}
