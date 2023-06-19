<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;


class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $request->validated();

        $userData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        $user = User::create($userData);
        $token = $user->createToken('backendapps')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 201);
    }
    
    public function login(LoginRequest $request)
    {
        $user =User::whereUsername($request->username)->first();
        if(!$user || !Hash::check($request->password,$user->password)){
            return response([
                'message' =>'username dan password tidak cocok'
            ],422);
  }

        $token = $user->createToken('backendapps')->plainTextToken;
        return response([
            'user' => $user,
            'token' => $token
        ], 200);
    }
}
