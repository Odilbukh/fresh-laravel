<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationCreateRequest;
use App\Http\Requests\NotificationUpdateRequest;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $notifications = Notification::paginate($request->input('perPage', 20));
        return response()->json($notifications, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NotificationCreateRequest $request)
    {
        $validated = $request->validated();
        $user_id = Auth::user()->id;
        $validated['user_id'] = $user_id;
        $notification = Notification::create($validated);
        if(!$notification){
            return response()->json(['error' => 'Notification cannot be created'], 500);
        }
        return response()->json('Notification created successfully', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json(Notification::findOrFail($id), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NotificationUpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $notification = Notification::update($validated,$id);
        if(!$notification){
            return response()->json(['error' => 'Notification cannot be updated'], 500);
        }
        return response()->json(['message'=>'Notification updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();
        return response()->json('Notification deleted successfully', 200);
    }
}
