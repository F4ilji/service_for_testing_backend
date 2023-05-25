<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $data = $request->validate([
            'name' => 'string|required',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $token = $user->createToken('myapptoken')->plainTextToken;

        return response(['user' => new UserResource($user), 'token' => $token], 201);
    }

    public function login(Request $request) {
        $user_fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $user_fields['email'])->first();

        if(!$user || !Hash::check($user_fields['password'], $user->password)) {
            return response([
                'message' => 'Incorrect email or password'
            ], 401);
        } else {
            $token = $user->createToken('myapptoken');
            $user->tokens()->where('id', '<>', $token->accessToken->id)->delete();
            return response(['user' => new UserResource($user), 'token' => $token->plainTextToken], 201);     
        }

    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);

    }
}
