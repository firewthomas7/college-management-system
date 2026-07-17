<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RoleRedirectController extends Controller
{
    /**
     * Redirect an authenticated user to their role-specific dashboard.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (! $user || ! $user->role) {
            auth()->logout();

            return redirect()->route('login')->withErrors([
                'email' => 'Your account has no role assigned. Please contact the administrator.',
            ]);
        }

        return match ($user->role->name) {
            'super_admin', 'admin' => redirect()->route('admin.dashboard'),
            'teacher' => redirect()->route('teacher.dashboard'),
            'student' => redirect()->route('student.dashboard'),
            'accountant' => redirect()->route('accountant.dashboard'),
            'librarian' => redirect()->route('librarian.dashboard'),
            'registrar' => redirect()->route('registrar.dashboard'),
            default => redirect()->route('login')->withErrors([
                'email' => 'No dashboard is configured for your role yet.',
            ]),
        };
    }
}
