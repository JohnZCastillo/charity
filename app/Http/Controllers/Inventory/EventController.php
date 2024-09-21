<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{

    public function index(Request $request)
    {

        $query = Event::query();

        $query->when($request->input('search'), function ($qb) use ($request) {
            $qb->where(function ($qb) use ($request) {
                $qb->whereLike('title', '%' . $request->input('search') . '%');
                $qb->orWhereLike('description', '%' . $request->input('search') . '%');
                $qb->orWhereLike('location', '%' . $request->input('search') . '%');
                $qb->orWhereDate('start', $request->input('search'));
                $qb->orWhereDate('end', $request->input('search'));
            });
        });

        $query->when($request->input('order'), function ($qb) use ($request) {
            $qb->orderBy($request->input('order'), $request->input('sort'));
        });

        $events = $query->paginate(10);

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
                'description' => 'required|string',
                'location' => 'required|string',
                'start' => 'required|date',
                'end' => 'required|date',
            ]);

            $event = Event::findOrFail($eventID);

            $event->fill($validated);

            if($request->file('image')){

                $filename = $request->file('image')->store('public');

                if(!$filename){
                    throw new \Exception('Image Upload Failed');
                }

                $event->image = $filename;
            }

            $event->save();

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

            $event = new Event();

            $event->fill($validated);

            $event->image = null;

            if ($request->file('image')) {

                $filename = $request->file('image')->store('public');

                if ($filename) {
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
