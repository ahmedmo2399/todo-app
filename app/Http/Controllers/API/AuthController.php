<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Resources\UserResource;
    
class AuthController extends Controller
{
    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|unique:users',
        'password' => 'required|string|confirmed|min:6',
    ]);

    // dd($request->all());
    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => bcrypt($request->password),
    ]);

    return response()->json([
        'message' => 'User registered successfully',
        'user' => new UserResource($user),
    ], 201);
}


    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            return response()->json([
                'token' => $user->createToken('api-token')->plainTextToken,
                'user' => new UserResource($user),
            ]);
        }



        return response()->json([
            'error' => 'Unauthorized',
        ], 401);

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();


        return response()->json(['message' => 'Logged out']);
    }
}

