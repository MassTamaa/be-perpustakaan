<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Roles;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'role:owner']);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Roles::all();

        return response()->json([
            'message' => 'List Of Roles',
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:roles'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'error' => $validator->errors()
            ], 400);
        }

        $role = Roles::create($request->all());

        return response()->json([
           'message' => 'Role Created Successfully',
            'role' => $role
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $role = Roles::find($id);

        if (!$role) {
            return response()->json([
               'message' => 'Role Not Found'
            ], 404);
        }

        return response()->json([
           'message' => 'Role Details',
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','string','max:255', 'unique:roles'],
        ]);

        if ($validator->fails()) {
            return response()->json([
               'message' => 'Validation Failed',
                'error' => $validator->errors()
            ], 400);
        }

        $role = Roles::find($id);

        if (!$role) {
            return response()->json([
               'message' => 'Role Not Found'
            ], 404);
        }

        $role->update($request->all());

        return response()->json([
           'message' => 'Role Updated Successfully',
            'role' => $role
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = Roles::find($id);

        if (!$role) {
            return response()->json([
               'message' => 'Role Not Found'
            ], 404);
        }

        $role->delete();

        return response()->json([
           'message' => 'Role Deleted Successfully'
        ]);
    }
}
