<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'role:owner'])->only('store', 'update', 'destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            "message" => "Show Category List",
            "categories" => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        Category::create($request->all());

        return response()->json([
            "message" => "Category Created Successfully"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::with('listBooks')->find($id);

        if (!$category) {
            return response()->json([
                "message" => "Category Not Found"
            ], 404);
        }

        return response()->json([
            "message" => "Show Category With ID : $id Successfully",
            "category" => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                "message" => "Category Not Found"
            ], 404);
        }

        $category->update($request->all());

        return response()->json([
            "message" => "Category Updated With ID : $id Successfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                "message" => "Category Not Found"
            ], 404);
        }

        $category->delete();

        return response()->json([
            "message" => "Category Deleted With ID : $id Successfully"
        ]);
    }
}
