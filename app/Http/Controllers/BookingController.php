<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingCreateRequest;
use App\Http\Requests\BookingUpdateRequest;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $hotels = Booking::paginate($request->input('perPage', 20));
        return response()->json($hotels, 200);
    }

    public function show($id)
    {
        return response()->json(Booking::findorfail($id), 200);
    }

    public function store(BookingCreateRequest $request)
    {
        $validated = $request->validated();

        if (!isset($validated['user_id'])) {
            $user_id = Auth::user()->id;
            $validated['user_id'] = $user_id;
        }

        $hotel = Hotel::find($validated['hotel_id']);
        $rooms = $hotel->rooms()->whereIn('id', $validated['rooms'])->get();

        if ($rooms->isEmpty()) {
            return response()->json(['The room does not exists'], 404);
        }

        $price_per_night = $rooms->sum('price_per_night');
        $days = Carbon::parse($validated['check_in_date'])->diffInDays($validated['check_out_date']);
        $total = $price_per_night * $days;
        $validated['total_amount'] = $total;
        unset($validated['rooms']);
        $validated['status'] = Booking::STATUS_CONFIRMED;

        $bookings = Booking::where('hotel_id', $validated['hotel_id'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('check_in_date', [$validated['check_in_date'], $validated['check_out_date']])
                    ->orWhereBetween('check_out_date', [$validated['check_in_date'], $validated['check_out_date']]);
            })
            ->get();

        if ($bookings->isNotEmpty()) {
            foreach ($bookings as $booking) {
                $exist = $booking->rooms()->whereIn('room_id', $rooms->pluck('id')->toArray())->exists();
                if ($exist) {
                    return response()->json("This room is occupied on that dates.", 404);
                }
            }
        }

        $booking = Booking::create($validated);

        if (!$booking) {
            return response()->json(['error' => 'Booking cannot be created'], 500);
        }

        $booking->rooms()->sync($rooms->pluck('id')->toArray());

        return response()->json('Booking is successfull', 200);
    }

    public function update(BookingUpdateRequest $request, $id)
    {
        $validated = $request->validated();

        $booking = Booking::update($validated);

        if (!$booking) {
            return response()->json(['error' => 'Booking cannot be updated'], 500);
        }

        return response()->json(['message' => 'Booking is successfull', 'booking' => $booking], 200);
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json([
            'message' => 'Booking was deleted successfully'
        ]);
    }
}
