<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return view('welcome', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'colour' => 'required|string|size:7',
        ]);

        $category = Category::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully.',
            'category' => $category
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    // In CategoryController.php
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:30',
            'colour' => ['required', 'regex:/^#([A-Fa-f0-9]{6})$/'],
        ]);

        $category = Category::findOrFail($id);

        $category->name = $request->input('name');
        $category->colour = $request->input('colour');
        $category->save();

        return response()->json(['success' => true, 'name' => $category->name, 'colour' => $category->colour]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {

        $category = Category::findOrFail($id);

        if ($category->events()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete category as it has related events.'
            ], 400);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully.'
        ], 200);
    }
}
