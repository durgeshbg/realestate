<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $fields = $request->validate([
            "email" => "required|email",
            "password" => "required|string"
        ]);
        $user = User::where('email', $fields['email'])->first();
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                "message" => "Bad Credentials",
            ], 401);
        }

        $token = $user->createToken('tokenmnn');

        return response([
            "user" => $user,
            "token" => $token->plainTextToken,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response([
            "message" => "Logged out successfully"
        ]);
    }
}
