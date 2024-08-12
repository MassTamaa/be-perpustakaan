<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth; 
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roles;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $roleUser = Roles::where('name', 'user')->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $roleUser->id,
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Registration Successfully',
            'user' => $user,
            "token" => $token
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {

            return response()->json
            ([
                'error' => 'Login Unauthorized'
            ], 401);
        }

        $UserData = User::with('role')->where('email', $request['email'])->first();

        $token = JWTAuth::fromUser($UserData);

        return response()->json([
            'message' => 'Login Successfully',
            'user' => $UserData,
            'token' => $token
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function logout()
    {
        auth()->logout();
        return response()->json
        ([
            'message' => 'Logged Out Successfully'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function getUser()
    {
        $user = auth()->user();

        $currentUser = User::with('role')->find($user->id);

        return response()->json([
            'message' => 'Getting user Successfully',
            'user' => $currentUser
        ], 200);
    }
}
