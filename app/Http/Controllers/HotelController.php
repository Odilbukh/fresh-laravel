<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelCreateRequest;
use App\Models\Hotel;
use App\Models\Project;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        $hotels = Hotel::paginate($request->input('perPage', 20));
        return response()->json($hotels, 200);
    }

    public function show($id)
    {
        return response()->json(Hotel::findorFail($id));
    }

    public function store(HotelCreateRequest $request)
    {
        $validated = $request->validated();
        $hotel = Hotel::create($validated);
        if (isset($valideted['user_ids'])) {
            $hotel->users()->sync($validated['user_ids']);
        }
        if (isset($validated['room_ids'])) {
            $hotel->rooms()->sync($validated['room_ids']);
        }
        if (!$hotel) {
            return response()->json(['message' => 'Hotel cannot be created']);
        }

        return response()->json(['message' => 'Hotel created successfully']);
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        $hotel->update([
            'name' => $request->name
        ]);

        if (isset($valideted['user_ids'])) {
            $hotel->users()->sync($request->user_ids);
        }
        if (isset($validated['room_ids'])) {
            $hotel->rooms()->sync($request->room_ids);
        }

        return response()->json([
            'message' => 'Hotel updated successfully',
            $hotel
        ]);
    }

    public function destroy($id)
    {

        $hotel = Hotel::findOrFail($id);
        $hotel->delete();

        return response()->json([
            'message' => 'Hotel was deleted successfully'
        ]);
    }

}
