<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use Illuminate\Support\Str;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'role:owner'])->only('store', 'update', 'destroy');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'summary' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|uuid',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            $imagePath = null;
        }

        $book = Book::create([
            'id' => Str::uuid(),
            'title' => $validatedData['title'],
            'stock' => $validatedData['stock'],
            'summary' => $validatedData['summary'],
            'image' => $imagePath,
            'category_id' => $validatedData['category_id'],
        ]);

        return response()->json([
           'message' => 'Book created successfully',
            'book' => $book,
        ], 201);
    }

    public function index()
    {
        $books = Book::with('category')->get();

        return response()->json([
           'message' => 'Show All Books Successfully',
           'books' => $books,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $book = Book::with('category', 'listBarrows')->find($id);

        if (!$book) {
            return response()->json([
               'message' => 'Book Not Found'
            ], 404);
        }

        return response()->json([
           'message' => 'Details Book Successfully',
           'book' => $book,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
               'message' => 'Book Not Found'
            ], 404);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'summary' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|uuid',
        ]);

        if ($request->hasFile('image')) {
           if ($book->image) {
             Storage::disk('public')->delete($book->image);
           }

           $imagePath = $request->file('image')->store('images', 'public');
           $book->image = $imagePath;
        }

        $book->title = $validatedData['title'];
        $book->stock = $validatedData['stock'];
        $book->summary = $validatedData['summary'];
        $book->category_id = $validatedData['category_id'];
        $book->save();

        return response()->json([
           'message' => 'Book Updated Successfully',
            'book' => $book,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
               'message' => 'Book Not Found'
            ], 404);
        }

        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        $book->delete();

        return response()->json([
           'message' => 'Book Deleted Successfully'
        ], 200);
    }
}
