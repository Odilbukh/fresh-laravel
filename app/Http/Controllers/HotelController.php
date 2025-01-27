<?php

namespace App\Http\Controllers;

use App\Filters\HotelFilter;
use App\Http\Requests\HotelCreateRequest;
use App\Http\Resources\HotelResource;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index(Request $request, HotelFilter $hotelFilter)
    {
        $hotels = Hotel::filter($hotelFilter)->paginate($request->input('perPage', 20));
        return new HotelResource($hotels);
    }

    public function show($id)
    {
        return new HotelResource(Hotel::findOrFail($id));
    }

    public function store(HotelCreateRequest $request)
    {
        $validated = $request->validated();
        $hotel = Hotel::create($validated);

        if (isset($validated['user_ids'])) {
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
