<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingCreateRequest;
use App\Http\Requests\BookingUpdateRequest;
use App\Models\Booking;
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

    public function show($id){
        return response()->json(Booking::findorfail($id), 200);
    }

    public function store(BookingCreateRequest $request){
        $validated = $request->validated();
        if(!isset($validated['user_id'])) {
            $user_id = Auth::user()->id;
            $validated['user_id'] = $user_id;
        }
        $room = Room::whereIn('id', $validated['rooms'])->get();
        $price_per_night = $room->sum('price_per_night');
        $days = Carbon::parse($validated['check_in_date'])->diffInDays($validated['check_out_date']);
        $total = $price_per_night * $days;
        $validated['total_amount'] = $total;
        unset($validated['rooms']);
        $validated['status']="ok";
        $booking = Booking::create($validated);
        if(!$booking){
            return response()->json(['error' => 'Booking cannot be created'], 500);
        }
        return response()->json('Booking is successfull', 200);
    }
    public function update(BookingUpdateRequest $request, $id){

        $validated = $request->validated();
        $booking = Booking::update($validated);
        if(!$booking){
            return response()->json(['error' => 'Booking cannot be updated'], 500);
        }
        return response()->json(['message'=>'Booking is successfull','booking'=>$booking], 200);
}
    public function destroy($id){
       $booking = Booking::findOrFail($id);
       $booking->delete();
        return response()->json([
            'message' => 'Booking was deleted successfully'
        ]);
    }
}
