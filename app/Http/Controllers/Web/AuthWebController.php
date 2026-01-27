<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class AuthWebController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'=>'required|email',
            'password'=>'required|string'
        ]);

        $response = Http::post(url('/api/login'),$credentials);

        if ($response->failed()) {
            return redirect()->back()->withErrors(['email'=>'Invalid credentials']);
        }

        $request->session()->put('user',$response->json('user'));

        return redirect()->route('todos.index');
    }

    public function logout(Request $request): RedirectResponse
    {
        Http::post(url('/api/logout'),[],[
            'cookies'=>$request->cookie()
        ]);

        $request->session()->flush();

        return redirect()->route('login');
    }
}