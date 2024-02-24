<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\EventResource;
use App\Http\Traits\CanLoadRelationShips;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    use CanLoadRelationShips;

    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index','show']);
        $this->authorizeResource(Event::class, 'event');
    }

    public function index()
    {
        $relations = ['user', 'attendees', 'attendees.user'];
        $query = $this->LoadRelationShips(Event::query());
        return EventResource::collection($query->latest()->paginate());
//        return response()->json([
//            'data' => Event::all(),
//            'status' => 200
//        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $event = Event::create([
            ...$request->validate([
                'name' => 'required|string|max:255|unique:events,name',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time'
            ]),
            'user_id' => $request->user()->id
        ]);

//        return response()->json([
//            'data' => $event,
//            'status' => 200
//        ]);
        return new EventResource($this->LoadRelationShips($event));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
//        $result = $event->load('attendees.user');
//        return response()->json([
//            'data' => $result,
//            'status' => 200
//        ]);
        $event->load('user', 'attendees');
        return new EventResource($event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
//        if (Gate::denies('update-event', $event)) {
//            abort(403 , 'Ypu not authorize');
//        }

        $this->authorize('update-event',$event);
        $event->update(
            $request->validate([
                'name' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'sometimes|date',
                'end_time' => 'sometimes|date|after:start_time'
            ])
        );

        return response()->json([
            'data' => $event,
            'code' => 200,
            'message' => "Updated Successfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return response(status: 204);
    }
}
