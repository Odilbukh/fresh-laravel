<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomCreateRequest;
use App\Http\Requests\RoomUpdateRequest;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $rooms = Room::paginate($request->input('perPage', 20));
        return response()->json($rooms, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomCreateRequest $request)
    {
        Gate::authorize('create', Room::class);
        $validated = $request->validated();
        $user_id = Auth::user()->id;
        $validated['user_id'] = $user_id;
        $room = Room::create($validated);
        if(!$room){
            return response()->json(['error' => 'Room cannot be created'], 500);
        }
        if($user_id)
        return response()->json('Room created successfully', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json(Room::findOrFail($id), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomUpdateRequest $request, $id)
    {

        $validated = $request->validated();
        $room = Room::update($validated,$id);
        if(!$room){
            return response()->json(['error' => 'Room cannot be updated'], 500);
        }
        return response()->json(['message'=>'Room updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return response()->json('Room deleted successfully', 200);
    }
}
