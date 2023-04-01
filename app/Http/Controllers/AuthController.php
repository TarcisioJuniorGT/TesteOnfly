<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'message' => 'Email or password invalid'
            ], 401);
        }
        $user = new UserResource(auth('api')->user());
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }
}
