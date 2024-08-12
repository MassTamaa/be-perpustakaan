<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bio' => 'required|string',
            'age' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
            ], 400);
        }

        $currentUser = auth()->user();

        // Tambahkan pengecekan apakah pengguna terautentikasi
        if (!$currentUser) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $profile = Profile::updateOrCreate(
            ['user_id' => $currentUser->id],
            [
                'bio' => $request['bio'],
                'age' => $request['age'],
                'user_id' => $currentUser->id,  
            ]
        );

        return response()->json([
            'message' => 'Create or Update Profile successfully',
            'profile' => $profile
        ], 201);
    }
}
