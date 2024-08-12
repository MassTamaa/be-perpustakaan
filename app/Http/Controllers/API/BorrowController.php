<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Borrow;

class BorrowController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'load_date' => 'required|date',
            'barrow_date' => 'required|date',
            'book_id' => 'required|exists:books,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'error' => $validator->errors()
            ], 422);
        }

        $currentUser = auth()->user();

        $borrow = Borrow::updateOrCreate(
            [
                'user_id' => $currentUser->id,
                'book_id' => $request['book_id'],
            ],
            [
                'load_date' => $request['load_date'],
                'barrow_date' => $request['barrow_date'],
            ]
        );

        return response()->json([
            'message' => 'Borrow Book Successfully',
            'borrow' => $borrow
        ]);
    }

    public function index() 
    {
        $borrows = Borrow::with('user', 'book')->get();

        return response()->json([
            "message" => "Show Borrows List",
            'borrows' => $borrows
        ]);
    }
}
