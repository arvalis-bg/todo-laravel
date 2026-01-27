<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;

class TodoWebController extends Controller
{
    public function index(Request $request): View
    {
        $response = Http::withCookies($request->session()->get('user'), url('/'))
                        ->get(url('/api/todos'));
        $todos = $response->json();
        return view('todos.index', compact('todos'));
    }

    public function create(): View
    {
        return view('todos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->only(['title','category_id','priority']);

        Http::withCookies($request->session()->get('user'), url('/'))
            ->post(url('/api/todos'), $data);

        return redirect()->route('todos.index');
    }

    public function edit(Request $request, int $id): View
    {
        $response = Http::withCookies($request->session()->get('user'), url('/'))
                        ->get(url("/api/todos/{$id}"));

        $todo = $response->json();

        return view('todos.edit', compact('todo'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $data = $request->only(['title','category_id','priority','completed']);

        Http::withCookies($request->session()->get('user'), url('/'))
            ->put(url("/api/todos/{$id}"), $data);

        return redirect()->route('todos.index');
    }

    public function toggle(Request $request,int $id): RedirectResponse
    {
        Http::withCookies($request->session()->get('user'), url('/'))
            ->patch(url("/api/todos/{$id}/toggle"));

        return redirect()->back();
    }

    public function stats(Request $request): View
    {
        $response = Http::withCookies($request->session()->get('user'), url('/'))
                        ->get(url('/api/todos/stats'));

        $stats = $response->json();

        return view('todos.stats', compact('stats'));
    }
}
