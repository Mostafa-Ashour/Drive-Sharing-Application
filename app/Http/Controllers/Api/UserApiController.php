<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:5',
            'email' => 'required|unique:users|email',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('token')->plainTextToken;
        $response = [
            'message' => 'User created Successfully.',
            'token' => $token,
            'data' => $user,
            'status' => 200,
        ];
        return response($response, 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', '=', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            $response = [
                'message' => "Invalid Credentials.",
                'status' => 200
            ];
            return response($response, 200);
        }

        $token = $user->createToken('token')->plainTextToken;
        $response = [
            'message' => 'Welcome back ' . $user->name,
            'user' => $user,
            'token' => $token,
            'status' => 200
        ];
        return response($response, 200);
    }

    public function logout(Request $request)
    {
        auth()->user()->currentAccessToken()->delete();
        $response = [
            'message' => 'Logged Out Successfully.',
            'status' => 200
        ];
        return response($response, 200);
    }
}
