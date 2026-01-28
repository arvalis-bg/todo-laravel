<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        // validate credentials
        $credentials = $request->validate([
            'email'=>'required|email',
            'password'=>'required|string'
        ]);

        // error if credentials don't match
        if (!Auth::attempt($credentials)) {
            return response()->json(['message'=>'Invalid credentials'],401);
        }

        $request->session()->regenerate();

        return response()->json([
            'message'=>'Logged in successfully',
            'user'=>Auth::user()
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        // logout and invalidate session
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message'=>'Logged out successfully']);
    }
}
