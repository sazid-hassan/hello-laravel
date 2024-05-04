<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {

        $categories = Category::all();
        return new JsonResponse($categories);
    }


    public function store(Request $request)
    {

        $category = Category::create($request->all());

        return new JsonResponse($category);
    }


    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);
            return new JsonResponse($category);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Category not found.'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
        $category->update($request->all());
    }


    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if ($category->products()->exists()) {
            return response()->json(['error' => 'Cannot delete category because it has associated products.'], 422);
        }

        $category->delete();

        return "Category Successfully Deleted";
    }


}
