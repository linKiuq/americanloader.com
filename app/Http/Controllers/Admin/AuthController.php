<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        return view('admin.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        try {
            $isAdmin = Auth::attempt($credentials, $request->boolean('remember')) && $request->user()?->is_admin;
        } catch (\Throwable) {
            Auth::logout();

            throw ValidationException::withMessages([
                'email' => 'The admin database is not ready yet. Check Hostinger database settings and migrations.',
            ]);
        }

        if (! $isAdmin) {
            Auth::logout();

            throw ValidationException::withMessages([
                'email' => 'The provided admin credentials are invalid.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('admin.login');
    }
}
