<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\AuthController as ApiAuthController;

class AuthWebController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Call API controller directly
        $apiController = app(ApiAuthController::class);
        $apiResponse = $apiController->login($request);

        if ($apiResponse->status() !== 200) {
            return redirect()->back()->withErrors([
                'email' => 'Invalid credentials',
            ]);
        }

        $userData = $apiResponse->getData(true)['user'] ?? null;

        if (!$userData) {
            return redirect()->back()->withErrors([
                'email' => 'Login failed',
            ]);
        }

        $request->session()->put('user', $userData);

        return redirect()->route('todos.index');
    }

    public function logout(Request $request): RedirectResponse
    {
        // Call API controller directly
        $apiController = app(ApiAuthController::class);
        $apiController->logout($request);

        $request->session()->flush();

        return redirect()->route('login');
    }
}
