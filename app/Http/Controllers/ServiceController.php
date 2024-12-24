<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceCreateRequest;
use App\Http\Requests\ServiceUpdateRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::paginate($request->input('perPage', 20));
        return response()->json($services, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceCreateRequest $request)
    {
        $validated = $request->validated();
        $user_id = Auth::user()->id;
        $validated['user_id'] = $user_id;
        $service = Service::create($validated);
        if(!$service){
            return response()->json(['error' => 'Service not created'], 500);
        }
        return response()->json('Service created successfully', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id){
        return response()->json(Service::findorfail($id), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceUpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $service = Service::update($validated, $id);
        if(!$service){
            return response()->json(['error' => 'Service not updated'], 500);
        }
        return response()->json('Service updated successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return response()->json('Service deleted successfully', 200);
    }
}
