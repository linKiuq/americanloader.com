<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

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

        $isAdmin = $this->attemptAdminLogin($request, $credentials);

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

    /**
     * Hostinger Git deploys can publish code before the SQLite database exists.
     * Repair that once on login so the admin dashboard is reachable.
     */
    private function attemptAdminLogin(Request $request, array $credentials): bool
    {
        try {
            return Auth::attempt($credentials, $request->boolean('remember')) && $request->user()?->is_admin;
        } catch (Throwable) {
            Auth::logout();
            $this->prepareAdminDatabase();

            try {
                return Auth::attempt($credentials, $request->boolean('remember')) && $request->user()?->is_admin;
            } catch (Throwable) {
                Auth::logout();

                throw ValidationException::withMessages([
                    'email' => 'The admin database is still not ready. Open Hostinger Terminal and run php artisan migrate --force.',
                ]);
            }
        }
    }

    private function prepareAdminDatabase(): void
    {
        $this->ensureSqliteDatabaseFile();

        Artisan::call('migrate', ['--force' => true]);

        $email = env('ADMIN_EMAIL', 'digital@typhonmachinery.com');
        $password = env('ADMIN_PASSWORD', 'LoaderAdmin2026!#');

        if (is_string($email) && is_string($password) && $email !== '' && $password !== '') {
            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => env('ADMIN_NAME', 'Admin'),
                    'password' => Hash::make($password),
                    'is_admin' => true,
                ]
            );
        }
    }

    private function ensureSqliteDatabaseFile(): void
    {
        if (config('database.default') !== 'sqlite') {
            return;
        }

        $databasePath = config('database.connections.sqlite.database');

        if (! is_string($databasePath) || $databasePath === ':memory:' || file_exists($databasePath)) {
            return;
        }

        $directory = dirname($databasePath);

        if (! is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        touch($databasePath);
    }
}
