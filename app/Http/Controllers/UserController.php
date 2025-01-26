<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $start = request()->query('start');
        $end = request()->query('end');
        if (request()->query('start')) {
            $start = $start - 1 < 0 ? 0 : $start - 1;
            $end = $end ? $start - $end : null;
            $users = array_slice($users->toArray(), $start, $end);
        }
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|unique:users,phone|max:15',
            'alternate_phone' => 'nullable|string|unique:users,alternate_phone|max:15',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'required|date',
            'role' => 'nullable|in:lead,admin',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
            'country' => 'required|string|max:255',
        ]);

        $user = User::create($request->all());
        return response()->json(['message' => 'User created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response(["message" => "User not found"], 404);
        } else {
            return response([$user], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'sometimes|string|min:8',
            'phone' => ['sometimes', 'string', 'max:15', Rule::unique('users', 'phone')->ignore($user->id)],
            'alternate_phone' => ['nullable', 'string', 'max:15', Rule::unique('users', 'alternate_phone')->ignore($user->id)],
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'sometimes|date',
            'role' => 'nullable|in:lead,admin',
            'address_line_1' => 'sometimes|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'sometimes|string|max:255',
            'state' => 'sometimes|string|max:255',
            'pincode' => 'sometimes|string|max:10',
            'country' => 'sometimes|string|max:255',
        ]);
        $user = $user->update($request->only([
            'name',
            'email',
            'password',
            'phone',
            'alternate_phone',
            'gender',
            'date_of_birth',
            'role',
            'address_line_1',
            'address_line_2',
            'city',
            'state',
            'pincode',
            'country',
        ]));
        return response()->json(['message' => 'User updated successfully', 201]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
