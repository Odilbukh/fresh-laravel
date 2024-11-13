<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::paginate($request->input('perPage', 20));
        return response()->json($products, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCreateRequest $request)
    {
        $validated = $request->validated();
        $product = Product::create($validated);

        if (!$product) {
            return response()->json(['message' => 'Product not created'], 500);
        }

        $product->users()->attach($request->user_ids);

        return response()->json(['message' => 'Product created'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json(Product::findorFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $product = Product::findOrFail($id);

        $product->update([
            'name' => $request->input('name')
        ]);

        $product->users()->sync($request->input('user_ids', []));

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'message' => 'Product was deleted successfully'
        ]);
    }
}
