<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        return response()->json(['data' => $products], 200);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'slug' => [
                'string',
                Rule::unique('product')->where(function ($query) use ($request) {
                    return $query->where('name', $request->name);
                })
            ],
            'desc' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'integer',
            'category_id' => 'required|exists:category,id',
        ]);

        $existingProduct = Product::where('name', $validatedData['name'])->first();

        if ($existingProduct) {
            return response()->json(['message' => 'Product already exists'], 409);
        }

        $product = Product::create($validatedData);

        return response()->json(['message' => 'Product created successfully', 'data' => $product], 201);
    }


    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
