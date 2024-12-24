<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceUpdateRequest;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::paginate($request->input('perPage', 10));
        return response()->json($invoices,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validated();
        $user_id = Auth::user()->id;
        $validated['user_id'] = $user_id;
        $invoice = Invoice::create($validated);
        if(!$invoice){
            return response()->json(['error' => 'Invoice cannot be created'], 500);
        }
        return response()->json('Invoice created successfully', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json(Invoice::findOrFail($id), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoiceUpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $invoice = Invoice::update($validated,$id);
        if(!$invoice){
            return response()->json(['error' => 'Invoice cannot be updated'], 500);
        }
        return response()->json(['message'=>'Invoice updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return response()->json('Invoice deleted successfully', 200);
    }
}
